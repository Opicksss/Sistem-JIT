<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class GrafikController extends Controller
{
    public function masuk(Request $request)
    {
        $tahunList = TransaksiMasuk::selectRaw('YEAR(tanggal_masuk) as tahun')->distinct()->pluck('tahun')->toArray();

        // Tahun terpilih dari URL (atau default ke tahun sekarang)
        $tahunTerpilih = $request->get('tahun', date('Y'));

        // Ambil total stok per bulan berdasarkan tahun
        $stokPerBulan = TransaksiMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, SUM(stok) as total_stok')->whereYear('tanggal_masuk', $tahunTerpilih)->groupByRaw('MONTH(tanggal_masuk)')->pluck('total_stok', 'bulan')->toArray();

        // Isi data lengkap 12 bulan (kosongkan jika tidak ada)
        $dataStok = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataStok[] = $stokPerBulan[$i] ?? 0;
        }

        // Nama bulan dalam Bahasa Indonesia
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('grafik.masuk', compact('tahunList', 'tahunTerpilih', 'dataStok', 'namaBulan'));
    }

    public function keluar(Request $request)
    {
        $tahunList = TransaksiKeluar::selectRaw('YEAR(tanggal_keluar) as tahun')->distinct()->pluck('tahun')->toArray();

        // Tahun terpilih dari URL (atau default ke tahun sekarang)
        $tahunTerpilih = $request->get('tahun', date('Y'));

        // Ambil total stok per bulan berdasarkan tahun
        $stokPerBulan = TransaksiKeluar::selectRaw('MONTH(tanggal_keluar) as bulan, SUM(stok) as total_stok')->whereYear('tanggal_keluar', $tahunTerpilih)->groupByRaw('MONTH(tanggal_keluar)')->pluck('total_stok', 'bulan')->toArray();

        // Isi data lengkap 12 bulan (kosongkan jika tidak ada)
        $dataStok = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataStok[] = $stokPerBulan[$i] ?? 0;
        }

        // Nama bulan dalam Bahasa Indonesia
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('grafik.keluar', compact('tahunList', 'tahunTerpilih', 'dataStok', 'namaBulan'));
    }
}
