<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;

//Route::get('/', [\App\Http\Controllers\CustomerController::class,'products'])->name('index');
Route::view('/','index')->name('home');
//Route::view('/home','welcome')->name('home');


Route::get('/importProducts', [\App\Http\Controllers\CustomerController::class,'importProducts']);
Route::get('/getProductsByInventoryID', [\App\Http\Controllers\CustomerController::class,'GetProductsByInventoryID']);
Route::get('/web-customers', [\App\Http\Controllers\CustomerController::class,'webCustomers']);
Route::get('/importCustomers', [\App\Http\Controllers\CustomerController::class,'importCustomers']);
Route::get('/getProductByCode/{code}', [\App\Http\Controllers\CustomerController::class,'getProductByCode']);
Route::get('/getCustomerByCode', [\App\Http\Controllers\CustomerController::class,'getCustomerByCode']);
Route::get('/getParty', [\App\Http\Controllers\CustomerController::class,'getParty']);
Route::get('/getBranches', [\App\Http\Controllers\CustomerController::class,'getBranches']);
