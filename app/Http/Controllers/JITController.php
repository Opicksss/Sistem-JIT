<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Carbon\Carbon;

class JITController extends Controller
{
    public function index()
    {
        $tahun = 2024;
        $bahanBakuId = 2;
        $bahanBaku = BahanBaku::find($bahanBakuId);

        // (a). Menghitung kuantitas pemesanan bahan baku
        $totalBiayaPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)
            ->whereYear('tanggal_masuk', $tahun)
            ->sum('biaya_pemesanan');

        $totalBiayaPenyimpanan = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)
            ->whereYear('tanggal_keluar', $tahun)
            ->sum('biaya_penyimpanan');

        $jumlahPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)
            ->whereYear('tanggal_masuk', $tahun)
            ->count();

        $D = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)
            ->whereYear('tanggal_keluar', $tahun)
            ->sum('stok');

        $O = $jumlahPemesanan > 0 ? ($totalBiayaPemesanan / $jumlahPemesanan) : 0;

        $C = $bahanBaku->harga / 2;

        $Q = ($O > 0 && $C > 0) ? sqrt((2 * $D * $O) / $C) : 0;

        // (b). Menghitung total biaya tahunan minimum
        $T = ($Q > 0) ? (($C * $Q) / 2) + (($O * $D) / $Q) : 0;

        // (c). Menghitung jumlah pengiriman yang optimal setiap kali pemesanan
        $a = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)
            ->whereYear('tanggal_keluar', $tahun)
            ->avg('sisa');

        
         $na = ($Q > 0 && $a > 0)
            ? ceil(pow(($Q / (2 * $a)), 2))
         : 0;

        //  (d). Menghitung kuantitas pemesanan untuk sekali pesan
        $akarNa = sqrt($na);
        $akarNaTigaAngka = floor($akarNa * 1000) / 1000;
        $Qn = floor($akarNaTigaAngka * $Q * 100) / 100;

        // (e). Menghitung kuantitas pengiriman
        $q = ($na > 0) ? ($Qn / $na) : 0;


        // (f), Menghitung frekuensi pembelian bahan baku dengan JIT
        $n = ($D > 0) ? floor($Qn / $D) : 0;



        // (3). Menghitung total biaya persediaan bahan baku dengan JIT
        $akarN = $n > 0 ? sqrt($n) : null;
        $pembagi = ($akarN && $akarN != 0) ? round(1 / $akarN, 3) : null;
        $TIJ = ($pembagi !== null && $T !== null) ? $pembagi * $T : null;

        // (4) Total biaya persediaan periode 2024 Kondisi Aktual
        $totalBiaya = $totalBiayaPenyimpanan + $totalBiayaPemesanan;

        return view('hasil.index', compact('D', 'O', 'C', 'Q', 'T', 'na', 'a', 'Qn', 'q', 'n', 'TIJ', 'pembagi', 'totalBiaya', 'akarNa', 'bahanBaku', 'totalBiayaPemesanan', 'totalBiayaPenyimpanan', 'jumlahPemesanan', 'tahun'));
    }

}