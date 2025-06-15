<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;

class JITController extends Controller
{
    public function index()
    {
        $tahun = request()->get('tahun', date('Y'));
        $bahanBakuId = request()->get('bahan_baku_id', BahanBaku::first()->id ?? null);

        $bahanBakuList = BahanBaku::all();
        $bahanBaku = BahanBaku::find($bahanBakuId);

        // Perhitungan Anda tetap sama...
        $totalBiayaPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_masuk', $tahun)->sum('biaya_pemesanan');

        $totalBiayaPenyimpanan = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->sum('biaya_penyimpanan');

        $jumlahPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_masuk', $tahun)->count();

        $D = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->sum('stok');

        $O = $jumlahPemesanan > 0 ? $totalBiayaPemesanan / $jumlahPemesanan : 0;
        $C = $bahanBaku->harga / 2;
        $Q = $O > 0 && $C > 0 ? sqrt((2 * $D * $O) / $C) : 0;
        $T = $Q > 0 ? ($C * $Q) / 2 + ($O * $D) / $Q : 0;
        $a = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->avg('sisa');
        $na = $Q > 0 && $a > 0 ? ceil(pow($Q / (2 * $a), 2)) : 0;
        $akarNa = sqrt($na);
        $akarNaTigaAngka = floor($akarNa * 1000) / 1000;
        $Qn = floor($akarNaTigaAngka * $Q * 100) / 100;
        $q = $na > 0 ? $Qn / $na : 0;
        $n = $D > 0 ? floor($Qn / $D) : 0;
        $akarN = $n > 0 ? sqrt($n) : null;
        $pembagi = $akarN && $akarN != 0 ? round(1 / $akarN, 3) : null;
        $TIJ = $pembagi !== null && $T !== null ? $pembagi * $T : null;
        $totalBiaya = $totalBiayaPenyimpanan + $totalBiayaPemesanan;

        $tahunList = TransaksiKeluar::selectRaw('YEAR(tanggal_keluar) as tahun')->distinct()->pluck('tahun')->toArray();

        return view('hasil.index', compact('D', 'Q', 'na', 'a', 'Qn', 'q', 'n', 'TIJ', 'totalBiaya', 'bahanBaku', 'jumlahPemesanan', 'tahun', 'tahunList', 'bahanBakuList'));
    }
}
