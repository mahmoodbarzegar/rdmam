<?php

use App\Livewire\Customer\Auth\CustomerLogin;
use App\Livewire\Customer\CustomerDashboard;
use App\Livewire\Customer\Auth\CustomerRegister;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('customer')->as('customer.')->group(function () {
    //    Route::get('/register', Register::class)->name('register');
    Route::get('/login', CustomerLogin::class)->name('login');
     Route::get('/register', CustomerRegister::class)->name('register');
});

Route::middleware('auth')->prefix('customer')->as('customer.')->group(function () {

     Route::get('/dashboard', CustomerDashboard::class)->name('dashboard');

    Route::post('/logout', function () {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('customer.login');
    })->name('logout');
});


