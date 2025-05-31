<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AcountController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikMasukController;
use App\Http\Controllers\DetailLaporanController;
use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiKeluarController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('login-proses', [AuthController::class, 'login_proses'])->name('login-proses');

    Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('forgot-proses', [AuthController::class, 'forgot_proses'])->name('forgot-proses');
    Route::get('verify-code', [AuthController::class, 'verify_code'])->name('verify-code');
    Route::post('verify-code-proses', [AuthController::class, 'verify_code_proses'])->name('verify-code-proses');
    Route::get('reset-password', [AuthController::class, 'reset_password'])->name('reset-password');
    Route::post('reset-password-proses', [AuthController::class, 'reset_password_proses'])->name('reset-password-proses');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('menuAkses:bahanBaku')->group(function () {
        Route::get('bahanBaku', [BahanBakuController::class, 'index'])->name('bahanBaku.index');
        Route::get('bahanBakuCreate', [BahanBakuController::class, 'create'])->name('bahanBaku.create');
        Route::post('bahanBaku', [BahanBakuController::class, 'store'])->name('bahanBaku.store');
        Route::get('bahanBaku{id}', [BahanBakuController::class, 'edit'])->name('bahanBaku.edit');
        Route::put('bahanBaku/{id}', [BahanBakuController::class, 'update'])->name('bahanBaku.update');
        Route::delete('bahanBaku/{id}', [BahanBakuController::class, 'destroy'])->name('bahanBaku.destroy');
    });

    Route::middleware('menuAkses:supplier')->group(function () {
        Route::get('supplier', [SuplierController::class, 'index'])->name('supplier.index');
        Route::get('supplierCreate', [SuplierController::class, 'create'])->name('supplier.create');
        Route::post('supplier', [SuplierController::class, 'store'])->name('supplier.store');
        Route::get('supplier{id}', [SuplierController::class, 'edit'])->name('supplier.edit');
        Route::put('supplier/{id}', [SuplierController::class, 'update'])->name('supplier.update');
        Route::delete('supplier/{id}', [SuplierController::class, 'destroy'])->name('supplier.destroy');
    });

    Route::middleware('menuAkses:transaksi_masuk')->group(function () {
        Route::get('transaksi_masuk', [TransaksiMasukController::class, 'index'])->name('transaksi_masuk.index');
        Route::get('transaksi_masukCreate', [TransaksiMasukController::class, 'create'])->name('transaksi_masuk.create');
        Route::post('transaksi_masuk', [TransaksiMasukController::class, 'store'])->name('transaksi_masuk.store');
        Route::get('transaksi_masuk{id}', [TransaksiMasukController::class, 'edit'])->name('transaksi_masuk.edit');
        Route::put('transaksi_masuk/{id}', [TransaksiMasukController::class, 'update'])->name('transaksi_masuk.update');
        Route::delete('transaksi_masuk/{id}', [TransaksiMasukController::class, 'destroy'])->name('transaksi_masuk.destroy');
        Route::get('/api/bahan-baku/{id}', [TransaksiMasukController::class, 'getBahanBaku']);
        Route::get('/api/suplier/{id}', [TransaksiMasukController::class, 'getSuplier']);
    });


    Route::middleware('menuAkses:laporan_masuk')->group(function () {
        Route::get('laporan_transaksi_masuk', [DetailLaporanController::class, 'index'])->name('laporan_masuk.index');
        Route::get('/detail_transaksi_masuk.{id}', [DetailLaporanController::class, 'show'])->name('detail_laporan_masuk.show');
        Route::get('/detail-laporan-masuk/print/{id}', [DetailLaporanController::class, 'printMasuk'])->name('detail_laporan_masuk.print');

    });

    Route::middleware('menuAkses:laporan_keluar')->group(function () {
        Route::get('laporan_transaksi_keluar', [DetailLaporanController::class, 'laporanKeluar'])->name('laporan_keluar.index');
        Route::get('/detail_transaksi_keluar.{id}', [DetailLaporanController::class, 'showLaporanKeluar'])->name('detail_laporan_keluar.show');
        Route::get('/detail-laporan-keluar/print/{id}', [DetailLaporanController::class, 'printKeluar'])->name('detail_laporan_keluar.print');
    });

    Route::middleware('menuAkses:transaksi_keluar')->group(function () {
        Route::get('transaksi_keluar', [TransaksiKeluarController::class, 'index'])->name('transaksi_keluar.index');
        Route::get('transaksi_keluarCreate', [TransaksiKeluarController::class, 'create'])->name('transaksi_keluar.create');
        Route::post('transaksi_keluarStore', [TransaksiKeluarController::class, 'store'])->name('transaksi_keluar.store');
        Route::get('/api/transaksi-keluar/bahan-baku/{id}', [TransaksiKeluarController::class, 'getBahanBaku']);
        Route::get('/api/transaksi-keluar/suplier/{id}', [TransaksiKeluarController::class, 'getSuplier']);
        Route::get('/api/transaksi-keluar/check-stok/{bahanBakuId}/{jumlah}', [TransaksiKeluarController::class, 'checkStok']);
        Route::delete('transaksi_keluar/{id}', [TransaksiKeluarController::class, 'destroy'])->name('transaksi_keluar.destroy');
    });

    Route::middleware('menuAkses:grafik_transaksi_masuk')->group(function () {
        Route::get('grafik_transaksi_masuk', [GrafikController::class, 'masuk'])->name('grafik.masuk');
    });

    Route::middleware('menuAkses:grafik_transaksi_keluar')->group(function () {
        Route::get('grafik_transaksi_keluar', [GrafikController::class, 'keluar'])->name('grafik.keluar');
    });

    Route::middleware(['userAkses:admin', 'menuAkses:acount'])->group(function () {
        Route::get('acount', [AcountController::class, 'index'])->name('acount.index');
        Route::get('acountCreate', [AcountController::class, 'create'])->name('acount.create');
        Route::post('acount', [AcountController::class, 'store'])->name('acount.store');
        Route::get('acount{user}', [AcountController::class, 'edit'])->name('acount.edit');
        Route::put('acount/{user}', [AcountController::class, 'update'])->name('acount.update');
        Route::delete('acount/{user}', [AcountController::class, 'destroy'])->name('acount.destroy');
    });
});

Route::get('home', function () {
    return redirect('dashboard');
});
