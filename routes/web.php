<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * Redirecionamento sempre para dashboard ou login
 */
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/**
 * Registro de usuários
 */
Route::view('/register', 'auth.register')->name('register');

/**
 * Login / Logout
 */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * Verificação de e-mail
 */
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'E-mail de verificação reenviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/**
 * Rotas autenticadas e verificadas
 */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', ['user' => auth()->user()]);
    })->name('dashboard');

    Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');
    Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');

    Route::get('/wallet', [WalletController::class, 'show'])->name('wallet.show');
    Route::get('/wallet/deposit', function () {
        return view('wallet.deposit');
    })->name('wallet.deposit');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit.store');

    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');
});

/**
 * Erros
 */
Route::fallback(function () {
    return response()->view('errors.error', [], 404);
});
