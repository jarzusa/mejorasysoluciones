<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Invoices api's
Route::get('/invoices', [\App\Http\Controllers\InvoiceController::class, 'all']);
Route::post('/invoices', [\App\Http\Controllers\InvoiceController::class, 'store']);
Route::post('/invoices/update/{invoice}', [\App\Http\Controllers\InvoiceController::class, 'update']);

// Items/Products api's
Route::get('/items', [\App\Http\Controllers\ItemController::class, 'all']);

// Transmitter api's
Route::get('/transmitter', [\App\Http\Controllers\TransmitterController::class, 'all']);

// Receptor api's
Route::get('/receptor', [\App\Http\Controllers\ReceptorController::class, 'all']);
