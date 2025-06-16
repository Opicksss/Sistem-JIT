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
        $Qn = $na > 0 ? floor(sqrt($na) * $Q * 100) / 100 : 0;
        $q = $na > 0 ? $Qn / $na : 0;
        $n = $D > 0 ? floor($Qn / $D) : 0;
        $TIJ = $n > 0 && $T !== null ? round((1 / sqrt($n)) * $T, 2) : null;
        $totalBiaya = $totalBiayaPemesanan + $totalBiayaPenyimpanan;

        // Hitung bulan pemesanan
        $bulanPemesanan = [];
        if ($n > 0) {
            for ($i = 0; $i < $n; $i++) {
                $bulanKe = round($i * (12 / $n) + 1);
                if ($bulanKe > 12) {
                    $bulanKe = 12;
                }
                $bulanPemesanan[] = $bulanKe;
            }
            // Hilangkan duplikat & urutkan
            $bulanPemesanan = array_unique($bulanPemesanan);
            sort($bulanPemesanan);

            // Konversi ke nama bulan
            $bulanPemesanan = array_map(function ($bln) {
                return ucfirst(\Carbon\Carbon::create()->month($bln)->locale('id')->monthName);
            }, $bulanPemesanan);
        }

        $tahunList = TransaksiKeluar::selectRaw('YEAR(tanggal_keluar) as tahun')->distinct()->pluck('tahun')->toArray();

        return view('hasil.index', compact('D', 'Q', 'na', 'a', 'Qn', 'q', 'n', 'TIJ', 'totalBiaya', 'bahanBaku', 'jumlahPemesanan', 'tahun', 'tahunList', 'bahanBakuList', 'bulanPemesanan'));
    }
}
