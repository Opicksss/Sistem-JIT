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

    public function printKeluar($id)
    {
        $transaksiKeluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])->findOrFail($id);

        $pdf = Pdf::loadView('laporan_keluar.detail_transaksi_keluar', compact('transaksiKeluar'))
            ->setPaper('a4');

        return $pdf->stream('detail_transaksi_keluar.pdf');
    }

    public function sisa()
    {
        // Ambil semua transaksi keluar tanpa duplikasi
        $transaksiKeluar = TransaksiKeluar::with(['bahanBaku', 'suplier'])
            ->orderBy('tanggal_keluar', 'desc')
            ->get();

        $dataSisa = [];
        $processedBahanBaku = []; // untuk menghindari duplikasi

        foreach ($transaksiKeluar as $keluar) {
            // Skip jika bahan baku sudah diproses
            if (in_array($keluar->bahan_baku_id, $processedBahanBaku)) {
                continue;
            }

            // Hitung stok masuk untuk bahan baku ini
            $stokMasuk = TransaksiMasuk::where('bahan_baku_id', $keluar->bahan_baku_id)
                ->get();
            $totalStokMasuk = $stokMasuk->sum('stok');

            // Hitung stok keluar untuk bahan baku ini
            $stokKeluar = TransaksiKeluar::where('bahan_baku_id', $keluar->bahan_baku_id)
                ->get();
            $totalStokKeluar = $stokKeluar->sum('stok');

            // Debug: tampilkan detail transaksi
            $detailMasuk = $stokMasuk->map(function ($item) {
                return "ID: {$item->id_transaksi}, Stok: {$item->stok}";
            })->implode(' | ');

            $detailKeluar = $stokKeluar->map(function ($item) {
                return "ID: {$item->id_transaksi}, Stok: {$item->stok}";
            })->implode(' | ');

            $dataSisa[] = [
                'id_transaksi' => $keluar->id_transaksi,
                'penerima' => $keluar->penerima,
                'nama_bahan_baku' => $keluar->bahanBaku->nama,
                'total_stok_masuk' => $totalStokMasuk,
                'total_stok_keluar' => $totalStokKeluar,
                'sisa_stok' => $totalStokMasuk - $totalStokKeluar,
                'tanggal_keluar' => $keluar->tanggal_keluar,
                // Debug info
                'detail_masuk' => $detailMasuk,
                'detail_keluar' => $detailKeluar,
                'count_transaksi_masuk' => $stokMasuk->count(),
                'count_transaksi_keluar' => $stokKeluar->count(),
            ];

            // Tandai bahan baku sebagai sudah diproses
            $processedBahanBaku[] = $keluar->bahan_baku_id;
        }

        return view('laporan_keluar.sisa', compact('dataSisa'));
    }
}
