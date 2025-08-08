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

        $na = $Q > 0 && $a > 0 ? ceil(pow($Q / (2 * $a), 2)) : 0; // 4,7

        // $Qtesting = $testing * $Q;
        // dd([
        //     '$Q' => $Q,
        //     '$na' => $na,
        //     '$akar na' => $testing,
        //     '$Qtesting' => $Qtesting
        // ]);

        // $Qn = $na > 0 ? round(sqrt($na) * $Q, 2) : 0;

        // $Qn = $na > 0 ? floor(sqrt($na) * $Q * 100) / 100 : 0;

        $akarNa = sqrt($na);
        $akarNaTigaAngka = floor($akarNa * 1000) / 1000;
        $Qn = floor($akarNaTigaAngka * $Q * 100) / 100;


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

        $penghematan1 = $Q != 0 ? ($D / $D) : 0;
        // dd($penghematan1);
        $frekuensi1 = $penghematan1 * 100;

        $penghematan2 = $Q - $Qn;
        // dd($penghematan2);
        $frekuensi2 = $Q != 0 ? ($penghematan2 / $Q) * 100 : 0;

        $penghematan3 = $jumlahPemesanan - $n;
        $frekuensi3 = $jumlahPemesanan != 0 ? ($penghematan3 / $jumlahPemesanan) * 100 : 0;

        $penghematan4 = $D - $q;
        $frekuensi4 = $D != 0 ? ($penghematan4 / $D) * 100 : 0;

        $penghematan5 = 1 - $na;
        $frekuensi5 = ($penghematan5 / 1) * 100;

        $penghematan6 = $totalBiaya - $TIJ;
        $frekuensi6 = $totalBiaya != 0 ? ($penghematan6 / $totalBiaya) * 100 : 0;

        return view('hasil.index', compact('D', 'Q', 'na', 'a', 'Qn', 'q', 'n', 'TIJ', 'totalBiaya', 'bulanList', 'bahanBaku', 'jumlahPemesanan', 'tahun', 'tahunList', 'bahanBakuList', 'bulanPemesanan', 'frekuensi1', 'frekuensi2', 'frekuensi3', 'frekuensi4', 'frekuensi5', 'frekuensi6'));
    }
}
