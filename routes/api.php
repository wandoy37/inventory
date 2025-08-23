<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemsController;
use App\Http\Controllers\Api\VendorsController;
use App\Http\Controllers\Api\ItemUnitTypeController;
use App\Http\Controllers\Api\RekeningVendorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/options/vendors', [VendorsController::class, 'vendors']);
Route::get('/options/items', [ItemsController::class, 'items']);
Route::get('/items/{item}/units', [ItemUnitTypeController::class, 'optionsByItem']);
Route::get('/rekening/{vendorId}', [RekeningVendorController::class, 'optionsByRekening']);
