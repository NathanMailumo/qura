<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/index', [HospitalController::class, 'index'])->name('index');


Route::get('/forgot-password', [PasswordResetController::class, 'showReset'])->name('password.reset');
Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])->name('password.request');

Route::get('/verify', [PasswordResetController::class, 'showVerify'])->name('verify');
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('password.otp.verify');

Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.show');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.reset.update');