<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('users.index')
        : redirect()->route('profile.show');
})->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/email-test', [UserController::class, 'sendTestEmail'])
        ->name('users.email.test');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
