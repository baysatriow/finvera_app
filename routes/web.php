<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Home
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return view('home');
})->name('home');


// AUTH (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/register/step1', [AuthController::class, 'showRegisterStep1'])->name('register.step1');
    Route::post('/register/step1', [AuthController::class, 'processRegisterStep1'])->name('register.step1.post');

    Route::get('/register/step2', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
    Route::post('/register/step2', [AuthController::class, 'processRegisterStep2'])->name('register.step2.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// MAIN APP (Auth Required)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/ai-recommendation', [DashboardController::class, 'getAiRecommendation'])->name('dashboard.ai');

    // Loan Wizard
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan/step1', [LoanController::class, 'storeStep1'])->name('loan.storeStep1');

    Route::get('/loan/step2', [LoanController::class, 'step2'])->name('loan.step2');
    Route::post('/loan/step2', [LoanController::class, 'storeStep2'])->name('loan.storeStep2');

    Route::get('/loan/step3', [LoanController::class, 'step3'])->name('loan.step3');
    Route::get('/loan/analyze', [LoanController::class, 'getAiAnalysis'])->name('loan.analyze');
    Route::post('/loan/submit', [LoanController::class, 'submitApplication'])->name('loan.submit');

    // Installments
    Route::get('/installments', [InstallmentController::class, 'index'])->name('installments.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Products CRUD
    Route::resource('products', ProductController::class);
});
