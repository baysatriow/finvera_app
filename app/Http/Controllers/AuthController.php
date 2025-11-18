<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================= REGISTER STEP 1 =================
    public function showRegisterStep1()
    {
        return view('auth.register-step1');
    }

    public function processRegisterStep1(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'phone_number' => 'required|string|max:20',
        ]);

        // Simpan data sementara ke session
        $request->session()->put('register_data', $request->only([
            'first_name', 'last_name', 'email', 'username', 'password', 'phone_number'
        ]));

        return redirect()->route('register.step2');
    }

    // ================= REGISTER STEP 2 =================
    public function showRegisterStep2(Request $request)
    {
        if (!$request->session()->has('register_data')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step2');
    }

    public function processRegisterStep2(Request $request)
    {
        $request->validate([
            'date_of_birth' => 'required|date',
            'occupation' => 'required|string|max:100',
            'monthly_income' => 'required|numeric',
            'address' => 'required|string',
        ]);

        $step1 = $request->session()->get('register_data');

        // Create User Baru
        $user = User::create([
            'first_name' => $step1['first_name'],
            'last_name' => $step1['last_name'],
            'email' => $step1['email'],
            'username' => $step1['username'],
            'password' => Hash::make($step1['password']),
            'phone_number' => $step1['phone_number'],
            'date_of_birth' => $request->date_of_birth,
            'occupation' => $request->occupation,
            'monthly_income' => $request->monthly_income,
            'address' => $request->address,
            'status' => 'active',
            'role' => 'borrower',
            'credit_score' => 500, // Default score
            'kyc_status' => 'not_verified',
        ]);

        $request->session()->forget('register_data');

        Auth::login($user);

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Finvera 👋');
    }

    // ================= LOGIN =================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            return redirect()
                ->route('dashboard.index')
                ->with('success', 'Login berhasil! Senang bertemu lagi 🙌');
        }

        return back()
            ->withErrors([
                'login' => 'Kredensial yang Anda masukkan salah!',
            ])
            ->onlyInput('username');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }
}
