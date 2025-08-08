<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Carbon\Carbon;

class JITController extends Controller
{
    public function index()
    {
        $tahun = request()->get('tahun', date('Y'));
        $bahanBakuId = request()->get('bahan_baku_id', BahanBaku::first()->id ?? null);

        $bahanBakuList = BahanBaku::all();
        $bahanBaku = BahanBaku::find($bahanBakuId);

        // Mengamnil total biaya pemesanan
        $totalBiayaPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_masuk', $tahun)->sum('biaya_pemesanan');

        $totalBiayaPenyimpanan = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->sum('biaya_penyimpanan');

        $jumlahPemesanan = TransaksiMasuk::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_masuk', $tahun)->count();
       
        $D = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->sum('stok');
        

        $O = $jumlahPemesanan > 0 ? $totalBiayaPemesanan / $jumlahPemesanan : 0;

        $C = $bahanBaku->harga / 2;

        // RUMUS Q
        $Q = $O > 0 && $C > 0 ? sqrt((2 * $O * $D) / $C) : 0;
        // RUMUS T
        $T = $Q > 0 ? ($C * $Q) / 2 + ($O * $D) / $Q : 0;

        $a = TransaksiKeluar::where('bahan_baku_id', $bahanBakuId)->whereYear('tanggal_keluar', $tahun)->avg('sisa');

        $na = $Q > 0 && $a > 0 ? ceil(pow($Q / (2 * $a), 2) ) : 0; // 4,7

        $Qn = $na > 0 ? round(sqrt($na) * $Q, 2) : 0;

        // $Qn = $na > 0 ? floor(sqrt($na) * $Q * 100) / 100 : 0;
        $q = $na > 0 ? $Qn / $na : 0;

        $n = $D > 0 ? floor($Qn / $D) : 0; // 4,7 = 4

        $TIJ = $n > 0 && $T !== null ? round((1 / sqrt($n)) * $T, 2) : null;
        
        $totalBiaya = $totalBiayaPemesanan + $totalBiayaPenyimpanan;

        $bulanList = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $bulanPemesanan = array_fill(1, 12, 0);

       for ($i = 0; $i < $n; $i++) {
            $bulanKe = round($i * (12 / $n) + 1);
            if ($bulanKe > 12) {
                $bulanKe = 12;
            }
            $bulanPemesanan[$bulanKe] = 1;
        } 

        $tahunList = TransaksiKeluar::selectRaw('YEAR(tanggal_keluar) as tahun')->distinct()->pluck('tahun')->toArray();

        return view('hasil.index', compact('D', 'Q', 'na', 'a', 'Qn', 'q', 'n', 'TIJ', 'totalBiaya', 'bulanList', 'bahanBaku', 'jumlahPemesanan', 'tahun', 'tahunList', 'bahanBakuList', 'bulanPemesanan'));
    }
}
