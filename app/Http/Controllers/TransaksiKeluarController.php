<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKeluar;
use App\Models\BahanBaku;
use App\Models\Suplier;
use Illuminate\Support\Facades\DB;

class TransaksiKeluarController extends Controller
{
    public function index()
    {
        $transaksi_keluars = TransaksiKeluar::with(['suplier', 'bahanBaku'])->get();
        return view('transaksi_keluar.index', compact('transaksi_keluars'));
    }

    public function create()
    {
        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_keluar.create', compact('supliers', 'bahan_bakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transaksi' => 'required|string|unique:transaksi_keluars',
            'penerima' => 'required|string',
            'tanggal_keluar' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.suplier_id' => 'required|exists:supliers,id',
            'items.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'items.*.stok' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Validasi stok tersedia untuk setiap item
            foreach ($request->items as $item) {
                $bahanBaku = BahanBaku::find($item['bahan_baku_id']);
                if ($bahanBaku->stok < $item['stok']) {
                    throw new \Exception("Stok {$bahanBaku->nama} tidak mencukupi! Stok tersedia: {$bahanBaku->stok}, diminta: {$item['stok']}");
                }
            }

            // Simpan setiap item transaksi
            foreach ($request->items as $item) {
                // Buat transaksi keluar
                // Stok akan otomatis berkurang melalui Model Event
                TransaksiKeluar::create([
                    'id_transaksi' => $request->id_transaksi,
                    'penerima' => $request->penerima,
                    'suplier_id' => $item['suplier_id'],
                    'bahan_baku_id' => $item['bahan_baku_id'],
                    'stok' => $item['stok'],
                    'tanggal_keluar' => $request->tanggal_keluar,
                ]);
            }

            DB::commit();

            return redirect()->route('transaksi_keluar.index')
                ->with('success', 'Transaksi keluar berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // API untuk mendapatkan data bahan baku dengan stok
    public function getBahanBaku($id)
    {
        $bahanBaku = BahanBaku::find($id);
        if ($bahanBaku) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $bahanBaku->id,
                    'id_bahan_baku' => $bahanBaku->id_bahan_baku,
                    'nama' => $bahanBaku->nama,
                    'satuan' => $bahanBaku->satuan,
                    'stok_tersedia' => $bahanBaku->stok
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Bahan baku tidak ditemukan'
        ]);
    }

    // API untuk mendapatkan data suplier
    public function getSuplier($id)
    {
        $suplier = Suplier::find($id);
        if ($suplier) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $suplier->id,
                    'nama' => $suplier->nama
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Suplier tidak ditemukan'
        ]);
    }

    // API untuk cek stok tersedia
    public function checkStok($bahanBakuId, $jumlah)
    {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        if (!$bahanBaku) {
            return response()->json([
                'success' => false,
                'message' => 'Bahan baku tidak ditemukan'
            ]);
        }

        $stokCukup = $bahanBaku->stok >= $jumlah;
        
        return response()->json([
            'success' => true,
            'stok_cukup' => $stokCukup,
            'stok_tersedia' => $bahanBaku->stok,
            'stok_diminta' => $jumlah,
            'message' => $stokCukup ? 'Stok mencukupi' : "Stok tidak mencukupi! Tersedia: {$bahanBaku->stok}"
        ]);
    }
}