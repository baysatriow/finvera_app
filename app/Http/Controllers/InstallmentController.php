<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Installment;

class InstallmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $loan = Loan::where('user_id', $user->user_id)
                    ->whereIn('status', ['active', 'defaulted', 'disbursed'])
                    ->with(['installments' => function($query) {
                        // Urutkan installment berdasarkan due_date
                        $query->orderBy('due_date', 'asc');
                    }])
                    ->first();

        if (!$loan) {
            return redirect()->route('dashboard.index')->with('error', 'Anda belum memiliki cicilan aktif.');
        }

        // Hitung Total Overdue & Denda
        $totalOverdue = $loan->installments->where('status', 'overdue')->sum('amount');
        $totalLateFee = $loan->installments->where('status', 'overdue')->sum('late_fee');

        // Cicilan berikutnya yang harus dibayar (Pending atau Overdue paling lama)
        $nextInstallment = $loan->installments
                                ->whereIn('status', ['pending', 'overdue'])
                                ->sortBy('due_date')
                                ->first();

        return view('dashboard.installments.index', compact('loan', 'nextInstallment', 'totalOverdue', 'totalLateFee'));
    }
}
