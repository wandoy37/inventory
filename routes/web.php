<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\VendorController;
use App\Models\Vendor;
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
Route::get('/daftar-barang', [ItemController::class, 'index'])->name('daftar.barang.index');
// Get data barang with yajra datatables
Route::get('/daftar-barang/data', [ItemController::class, 'getData'])->name('daftar.barang.data');
// Page Create new barang
Route::get('/daftar-barang/create', [ItemController::class, 'create'])->name('daftar.barang.create');
// Store Process new barang
Route::post('/daftar-barang/store', [ItemController::class, 'store'])->name('daftar.barang.store');
// Edit barang
Route::get('/daftar-barang/edit/{id}', [ItemController::class, 'edit'])->name('daftar.barang.edit');
// Update process barang
Route::put('/daftar-barang/update/{id}', [ItemController::class, 'update'])->name('daftar.barang.update');
// Route untuk hapus satuan yang sudah ada
Route::delete('/daftar-barang/satuan/{id}', [ItemController::class, 'destroySatuan'])->name('daftar.barang.satuan.destroy');

// Daftar Vendor
Route::resource('/daftar-vendor', VendorController::class);

// Stock Opname
Route::resource('/stock-opname', StockOpnameController::class);
// Filter Stock Opname
Route::get('stock-opname/filter/{payment_type}', function ($payment_type) {
    if ($payment_type === 'all') {
        session()->forget('payment_type_filter'); // hapus filter
    } else {
        // ganti tanda '-' jadi '/' kalau ada
        $payment_type = str_replace('-', '/', $payment_type);
        session(['payment_type_filter' => $payment_type]);
    }
    return redirect()->route('stock-opname.index');
})->name('stock-opname.filter');
