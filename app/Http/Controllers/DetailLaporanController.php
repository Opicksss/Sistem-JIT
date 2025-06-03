<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


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


    public function printMasuk($id)
    {
        $transaksiMasuk = TransaksiMasuk::with(['suplier', 'bahanBaku'])->findOrFail($id);

        $pdf = Pdf::loadView('laporan_masuk.detail_transaksi_masuk', compact('transaksiMasuk'))
            ->setPaper('a4');

        return $pdf->stream('detail_transaksi_masuk.pdf');
    }


    // Laporan Transaksi Keluar

    public function laporanKeluar()
    {
        $transaksiKeluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('laporan_keluar.index', compact('transaksiKeluar'));
    }

    public function showLaporanKeluar($id)
    {
        $transaksiKeluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])
            ->findOrFail($id);
        return view('laporan_keluar.show', compact('transaksiKeluar'));
    }

    public function sisa($id)
    {
        $transaksiKeluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])
            ->findOrFail($id);
        return view('laporan_keluar.sisa', compact('transaksiKeluar'));
    }


    public function printKeluar($id)
    {
        $transaksiKeluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])->findOrFail($id);

        $pdf = Pdf::loadView('laporan_keluar.detail_transaksi_keluar', compact('transaksiKeluar'))
            ->setPaper('a4');

        return $pdf->stream('detail_transaksi_keluar.pdf');
    }
}
