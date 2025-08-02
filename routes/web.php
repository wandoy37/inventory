<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bank-account', [BankAccountController::class, 'index'])->name('bankaccount.index');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Daftar Barang
Route::get('/daftar-barang', [ItemController::class, 'index'])->name('daftarbarang.index');
