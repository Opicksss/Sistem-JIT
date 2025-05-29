<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcountController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiKeluarController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');

    Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('/forgot-proses', [AuthController::class, 'forgot_proses'])->name('forgot-proses');
    Route::get('verify-code', [AuthController::class, 'verify_code'])->name('verify-code');
    Route::post('verify-code-proses', [AuthController::class, 'verify_code_proses'])->name('verify-code-proses');
    Route::get('reset-password', [AuthController::class, 'reset_password'])->name('reset-password');
    Route::post('reset-password-proses', [AuthController::class, 'reset_password_proses'])->name('reset-password-proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bahanBaku', [BahanBakuController::class, 'index'])->name('bahanBaku.index');
    Route::get('/bahanBakuCreate', [BahanBakuController::class, 'create'])->name('bahanBaku.create');
    Route::post('/bahanBaku', [BahanBakuController::class, 'store'])->name('bahanBaku.store');
    Route::get('/bahanBaku{id}edit', [BahanBakuController::class, 'edit'])->name('bahanBaku.edit');
    Route::put('/bahanBaku/{id}', [BahanBakuController::class, 'update'])->name('bahanBaku.update');
    Route::delete('/bahanBaku/{id}', [BahanBakuController::class, 'destroy'])->name('bahanBaku.destroy');

    Route::get('/supplier.index', [SuplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier.create', [SuplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier.store', [SuplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier.edit.{id}', [SuplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier.update/{id}', [SuplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier.destroy.{id}', [SuplierController::class, 'destroy'])->name('supplier.destroy');

    Route::get('/transaksi_masuk.index', [TransaksiMasukController::class, 'index'])->name('transaksi_masuk.index');
    Route::get('/transaksi_masuk.create', [TransaksiMasukController::class, 'create'])->name('transaksi_masuk.create');
    Route::post('/transaksi_masuk.store', [TransaksiMasukController::class, 'store'])->name('transaksi_masuk.store');
    Route::get('/transaksi_masuk.edit.{id}', [TransaksiMasukController::class, 'edit'])->name('transaksi_masuk.edit');
    Route::put('/transaksi_masuk.update/{id}', [TransaksiMasukController::class, 'update'])->name('transaksi_masuk.update');
    Route::delete('/transaksi_masuk.destroy.{id}', [TransaksiMasukController::class, 'destroy'])->name('transaksi_masuk.destroy');

    Route::get('/transaksi_keluar.index', [TransaksiKeluarController::class, 'index'])->name('transaksi_keluar.index');
    Route::get('/transaksi_keluar.create', [TransaksiKeluarController::class, 'create'])->name('transaksi_keluar.create');
    Route::post('/transaksi_keluar.store', [TransaksiKeluarController::class, 'store'])->name('transaksi_keluar.store');
    Route::get('/transaksi_keluar.edit.{id}', [TransaksiKeluarController::class, 'edit'])->name('transaksi_keluar.edit');
    Route::put('/transaksi_keluar.update/{id}', [TransaksiKeluarController::class, 'update'])->name('transaksi_keluar.update');
    Route::delete('/transaksi_keluar.destroy.{id}', [TransaksiKeluarController::class, 'destroy'])->name('transaksi_keluar.destroy');

    Route::middleware('userAkses:pegawai')->group(function () {});

    Route::middleware('userAkses:admin')->group(function () {
        Route::get('acount', [AcountController::class, 'index'])->name('acount.index');
        Route::get('acount.create', [AcountController::class, 'create'])->name('acount.create');
        Route::post('acount/store', [AcountController::class, 'store'])->name('acount.store');
        Route::get('acount.edit.{user}', [AcountController::class, 'edit'])->name('acount.edit');
        Route::put('acount/{user}', [AcountController::class, 'update'])->name('acount.update');
        Route::delete('acount/{user}', [AcountController::class, 'destroy'])->name('acount.destroy');
    });
});

Route::get('/home', function () {
    return redirect('/dashboard');
});
