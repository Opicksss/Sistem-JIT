<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
$tahun = date('Y');

    // Data untuk chart
    $stokMasukPerBulan = TransaksiMasuk::selectRaw('MONTH(tanggal_masuk) as bulan, SUM(stok) as total')
        ->whereYear('tanggal_masuk', $tahun)
        ->groupByRaw('MONTH(tanggal_masuk)')
        ->pluck('total', 'bulan')->toArray();

    $stokKeluarPerBulan = TransaksiKeluar::selectRaw('MONTH(tanggal_keluar) as bulan, SUM(stok) as total')
        ->whereYear('tanggal_keluar', $tahun)
        ->groupByRaw('MONTH(tanggal_keluar)')
        ->pluck('total', 'bulan')->toArray();

    $dataMasuk = [];
    $dataKeluar = [];
    for ($i = 1; $i <= 12; $i++) {
        $dataMasuk[] = $stokMasukPerBulan[$i] ?? 0;
        $dataKeluar[] = $stokKeluarPerBulan[$i] ?? 0;
    }

    $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Hitung total
    $totalSupplier = Suplier::count();
    $totalMasuk = TransaksiMasuk::count();
    $totalKeluar = TransaksiKeluar::count();

    return view('dashboard', compact(
        'namaBulan',
        'dataMasuk',
        'dataKeluar',
        'totalSupplier',
        'totalMasuk',
        'totalKeluar',
        'tahun'
    ));

    }

}
