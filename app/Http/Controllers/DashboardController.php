<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeLoan = Loan::where('user_id', $user->user_id)
            ->whereIn('status', ['active', 'disbursed'])
            ->first();

        return view('dashboard.index', compact('user', 'activeLoan'));
    }

    public function getAiRecommendation()
    {
        $user = Auth::user();

        $activeLoan = Loan::where('user_id', $user->user_id)
            ->whereIn('status', ['active', 'disbursed'])
            ->first();

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'status' => 'success',
                'recommendation' => 'Atur GEMINI_API_KEY di .env untuk mengaktifkan fitur rekomendasi AI.'
            ]);
        }

        $financialContext = "User: {$user->first_name}, Pendapatan: Rp " . number_format($user->monthly_income ?? 5000000, 0);

        if ($activeLoan) {
            $financialContext .= ", Pinjaman Aktif: Rp " . number_format($activeLoan->amount, 0) . ", Tenor: {$activeLoan->tenor} bulan.";
        } else {
            $financialContext .= ", Tidak ada pinjaman aktif.";
        }

        $prompt = "Berikan rekomendasi keuangan singkat (maks 2 kalimat) dalam Bahasa Indonesia berdasarkan konteks berikut: $financialContext";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}",
                ['contents' => [['parts' => [['text' => $prompt]]]]]
            );

            if ($response->successful()) {
                $text = $response->json()['candidates'][0]['content']['parts'][0]['text'];

                return response()->json([
                    'status' => 'success',
                    'recommendation' => $text
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'recommendation' => 'Sistem AI sedang tidak tersedia, silakan coba lagi nanti.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'recommendation' => 'Rekomendasi tidak dapat ditampilkan.'
        ]);
    }
}
