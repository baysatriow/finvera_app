<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\LoanApplication;
use App\Models\KycVerification;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\Installment;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();

        $existingApp = LoanApplication::where('user_id', $user->user_id)
            ->whereIn('status', ['draft', 'pending'])
            ->first();

        if ($existingApp) {
            if ($existingApp->kyc_verification_id) {
                return redirect()->route('loan.step3');
            }
            return redirect()->route('loan.step2');
        }

        $products = LoanProduct::where('status', 'active')->get();
        $selectedProduct = $request->query('product_id');

        return view('dashboard.loan.create', compact('products', 'selectedProduct'));
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:loan_products,product_id',
        ]);

        $product = LoanProduct::findOrFail($request->product_id);

        $request->validate([
            'purpose' => 'required|string|min:5',
            'amount' => ['required','numeric',"min:{$product->min_amount}","max:{$product->max_amount}"],
            'tenor'  => ['required','integer',"min:{$product->min_tenor}","max:{$product->max_tenor}"],
        ]);

        LoanApplication::updateOrCreate(
            ['user_id' => Auth::id(), 'status' => 'draft'],
            [
                'product_id'       => $product->product_id,
                'purpose'          => $request->purpose,
                'amount'           => $request->amount,
                'tenor'            => $request->tenor,
                'application_date' => now(),
                'max_amount'       => $product->max_amount,
            ]
        );

        return redirect()->route('loan.step2');
    }

    public function step2()
    {
        $application = LoanApplication::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->firstOrFail();

        return view('dashboard.loan.step2_kyc', compact('application'));
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'nik'          => ['required', 'regex:/^[0-9]{16}$/'],
            'ktp_image'    => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'selfie_image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        try {
            $aiCheck = $this->analyzeKycWithGemini($request->file('ktp_image'), $request->nik);

            if (!$aiCheck['valid']) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $aiCheck['reason']
                ], 422);
            }

            $ktpPath    = $request->file('ktp_image')->store('kyc/ktp', 'public');
            $selfiePath = $request->file('selfie_image')->store('kyc/selfie', 'public');

            $kyc = KycVerification::create([
                'user_id'              => Auth::id(),
                'id_card_number'       => $request->nik,
                'id_card_image'        => $ktpPath,
                'selfie_with_id_image' => $selfiePath,
                'status'               => 'verified',
                'verified_at'          => now(),
            ]);

            $app = LoanApplication::where('user_id', Auth::id())
                ->where('status', 'draft')
                ->first();

            if ($app) {
                $app->kyc_verification_id = $kyc->verification_id;
                $app->save();
            }

            return response()->json([
                'status'       => 'success',
                'redirect_url' => route('loan.step3')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }

    public function step3()
    {
        $application = LoanApplication::where('user_id', Auth::id())
            ->with(['kycVerification', 'product'])
            ->firstOrFail();

        return view('dashboard.loan.step3_review', compact('application'));
    }

    public function getAiAnalysis()
    {
        $application = LoanApplication::where('user_id', Auth::id())
            ->with('product')
            ->firstOrFail();

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json(['status' => 'success', 'analysis' => 'Risiko Rendah (Simulasi).']);
        }

        $prompt = "Analisis risiko pinjaman singkat: Produk {$application->product->description}, Nominal Rp "
            . number_format($application->amount)
            . ", Tenor {$application->tenor} bulan. Format: 'Risiko [Rendah/Sedang]. [Alasan singkat]'.";

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}", [
                    'contents' => [['parts' => [['text' => $prompt]]]]
                ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'analysis' => $response->json()['candidates'][0]['content']['parts'][0]['text']
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'analysis' => 'Gagal memuat analisis.']);
        }

        return response()->json(['status' => 'error', 'analysis' => 'AI tidak merespon.']);
    }

    public function submitApplication(Request $request)
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            $app = LoanApplication::where('user_id', $user->user_id)
                ->with('product')
                ->lockForUpdate()
                ->firstOrFail();

            if ($app->status == 'approved') {
                DB::rollBack();
                return redirect()->route('dashboard.index');
            }

            $app->status = 'approved';
            $app->save();

            $loan = Loan::create([
                'loan_number'       => 'LN-' . date('ymd') . rand(1000, 9999),
                'user_id'           => $user->user_id,
                'product_id'        => $app->product_id,
                'amount'            => $app->amount,
                'tenor'             => $app->tenor,
                'purpose'           => $app->purpose,
                'status'            => 'active',
                'disbursement_date' => now(),
                'due_date'          => now()->addMonths($app->tenor),
                'application_date'  => $app->application_date,
                'approval_date'     => now(),
                'approved_by'       => 1
            ]);

            $monthly = ceil($app->amount / $app->tenor);

            for ($i = 1; $i <= $app->tenor; $i++) {
                Installment::create([
                    'loan_id'           => $loan->loan_id,
                    'installment_number'=> $i,
                    'due_date'          => now()->addMonths($i),
                    'amount'            => $monthly,
                    'status'            => 'pending'
                ]);
            }

            if ($user->kyc_status !== 'verified') {
                $user->kyc_status = 'verified';
                $user->save();
            }

            DB::commit();

            return redirect()->route('dashboard.index')
                ->with('success', 'Pinjaman disetujui dan dana telah dicairkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pinjaman.');
        }
    }

    private function analyzeKycWithGemini($imageFile, $nik)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return ['valid' => true, 'reason' => 'Simulasi'];
        }

        $imageData = base64_encode(file_get_contents($imageFile->getRealPath()));
        $mimeType  = $imageFile->getMimeType();

        $prompt = "Cek apakah gambar berikut adalah KTP Indonesia, dan apakah NIK '{$nik}' cocok. Respon wajib JSON: {\"valid\": boolean, \"reason\": \"string\"}.";

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key={$apiKey}", [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            ['inlineData' => ['mimeType' => $mimeType, 'data' => $imageData]]
                        ]
                    ]],
                    'generationConfig' => ['responseMimeType' => 'application/json']
                ]);

            if ($response->successful()) {
                $raw = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
                $clean = str_replace(['```json', '```'], '', $raw);
                return json_decode($clean, true);
            }
        } catch (\Exception $e) {
            return ['valid' => true, 'reason' => 'Bypass (timeout)'];
        }

        return ['valid' => false, 'reason' => 'Verifikasi gagal'];
    }
}
