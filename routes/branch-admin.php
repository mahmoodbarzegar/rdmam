<?php

use App\Livewire\BranchAdmin\Auth\BranchAdminLogin;
use App\Livewire\BranchAdmin\BranchAdminDashboard;
use App\Livewire\BranchAdmin\BranchAdminShowCustomer;

Route::middleware('guest')->prefix('branchAdmin')->as('branchAdmin.')->group(function () {
    Route::get('/login', BranchAdminLogin::class)->name('login');
});

Route::middleware('auth')->prefix('branchAdmin')->as('branchAdmin.')->group(function () {

    Route::get('/customers', BranchAdminDashboard::class)->name('customers.list');
    Route::get('/customer/show/{customer}', BranchAdminShowCustomer::class)->name('customers.show');
});
