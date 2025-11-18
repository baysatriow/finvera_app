<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
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

        // simpan data sementara ke session
        $request->session()->put('register_data', $request->only([
            'first_name', 'last_name', 'email', 'username', 'password', 'phone_number'
        ]));

        return redirect()->route('register.step2');
    }

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

        // create user
        $user = User::create([
            ...$step1,
            'password' => Hash::make($step1['password']),
            'date_of_birth' => $request->date_of_birth,
            'occupation' => $request->occupation,
            'monthly_income' => $request->monthly_income,
            'address' => $request->address,
            'status' => 'active',
            'role' => 'borrower',
            // optional default
            'credit_score' => 500,
            'kyc_status' => 'not_verified',
        ]);

        // hapus data sementara register
        $request->session()->forget('register_data');

        // langsung login user baru
        Auth::login($user);

        // kasih flash message untuk SweetAlert
        return redirect()
            ->route('home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Finvera 👋');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // coba login pakai email
        if (
            Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]) ||
            Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])
        ) {
            $request->session()->regenerate();

            return redirect()
                ->route('dashboard.index')
                ->with('success', 'Login berhasil! Senang bertemu lagi 🙌');
        }

        return back()
            ->withErrors([
                'login' => 'Kredensial salah!',
            ])
            ->onlyInput('email');
    }
}
