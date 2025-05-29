<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class DetailLaporanController extends Controller
{
    public function index()
    {
        $transaksiMasuk = TransaksiMasuk::with(['suplier', 'bahanBaku'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('laporan_masuk.index', compact('transaksiMasuk'));
    }
    public function show($id)
    {
        $transaksiMasuk = TransaksiMasuk::with(['suplier', 'bahanBaku'])
            ->findOrFail($id);
        return view('laporan_masuk.show', compact('transaksiMasuk'));
    }

    public function laporanKeluar()
    {
        $transaksiKeluar = TransaksiMasuk::with(['suplier', 'bahanBaku'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('laporan_keluar.index', compact('transaksiKeluar'));
    }

    public function showLaporanKeluar($id)
    {
        $transaksiKeluar = TransaksiMasuk::with(['suplier', 'bahanBaku'])
            ->findOrFail($id);
        return view('laporan_keluar.show', compact('transaksiKeluar'));
    }
}
