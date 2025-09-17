<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Dashboard;
use App\Livewire\PemeriksaanCrud;
use App\Http\Controllers\TransaksiSyncController;
use App\Livewire\TransaksiCrud;
use App\Livewire\PasienCrud;
use App\Livewire\UnitAsalCrud;
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
    return redirect()->route('login.show');
});
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('auth');
Route::get('/pemeriksaan', PemeriksaanCrud::class)->name('pemeriksaan');
Route::get('/transaksi/sync', [TransaksiSyncController::class, 'sync'])->name('transaksi.sync');
Route::get('/transaksi', TransaksiCrud::class)->name('transaksi');
Route::get('/pasien', PasienCrud::class)->name('pasien');
Route::get('/unit-asal', UnitAsalCrud::class)->name('unit-asal');