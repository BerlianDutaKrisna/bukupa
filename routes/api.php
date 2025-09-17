<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiSyncController;
use App\Http\Controllers\PemeriksaanSyncController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/transaksi/recent', [TransaksiSyncController::class, 'recent']);
Route::post('/pemeriksaan/update-status', [PemeriksaanSyncController::class, 'updateStatus']);
