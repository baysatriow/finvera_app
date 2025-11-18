<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanProduct;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = LoanProduct::all();
        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        return view('dashboard.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_type' => 'required|in:installment,payday,micro,mortgage,business',
            'description' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'min_tenor' => 'required|integer|min:1',
            'max_tenor' => 'required|integer|gte:min_tenor',
            'late_fee_percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:active,inactive',
        ], [
            'max_amount.gt' => 'Maksimum pinjaman harus lebih besar dari minimum pinjaman.',
            'max_tenor.gte' => 'Maksimum tenor harus lebih besar atau sama dengan minimum tenor.'
        ]);

        $validated['created_by'] = Auth::user()->user_id;
        $validated['eligibility_criteria'] = json_encode([]);

        LoanProduct::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $product = LoanProduct::findOrFail($id);
        return view('dashboard.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = LoanProduct::findOrFail($id);

        $validated = $request->validate([
            'product_type' => 'required|in:installment,payday,micro,mortgage,business',
            'description' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'min_tenor' => 'required|integer|min:1',
            'max_tenor' => 'required|integer|gte:min_tenor',
            'late_fee_percentage' => 'required|numeric|between:0,100',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = LoanProduct::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
