<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiMasuk;
use App\Models\BahanBaku;
use App\Models\Suplier;
use Illuminate\Support\Facades\DB;

    class TransaksiMasukController extends Controller
    {
        public function index()
        {
            $transaksi_masuks = TransaksiMasuk::with(['suplier', 'bahanBaku'])->get();
            return view('transaksi_masuk.index', compact('transaksi_masuks'));
        }

        public function create()
        {
            $supliers = Suplier::all();
            $bahan_bakus = BahanBaku::all();
            return view('transaksi_masuk.create', compact('supliers', 'bahan_bakus'));
        }

        public function store(Request $request)
        {
            $request->validate([
                'id_transaksi' => 'required|string|unique:transaksi_masuks',
                'penerima' => 'required|string',
                'tanggal_masuk' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.suplier_id' => 'required|exists:supliers,id',
                'items.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
                'items.*.stok' => 'required|numeric|min:0.001',
            ]);

            try {
                DB::beginTransaction();

                
                foreach ($request->items as $item) {

                    $bahanBaku = BahanBaku::find($item['bahan_baku_id']);
                    $biayaPemesanan = floatval($item['stok']) * $bahanBaku->harga;
                    // dd($biayaPemesanan);
                    TransaksiMasuk::create([
                        'id_transaksi' => $request->id_transaksi,
                        'penerima' => $request->penerima,
                        'suplier_id' => $item['suplier_id'],
                        'bahan_baku_id' => $item['bahan_baku_id'],
                        'stok' => floatval($item['stok']),
                        'tanggal_masuk' => $request->tanggal_masuk,
                        'biaya_pemesanan' => $biayaPemesanan,
                    ]);

                    //  $bahanBaku->increment('stok', floatval($item['stok']));
                }

                DB::commit();

                return redirect()->route('transaksi_masuk.index')
                    ->with('success', 'Transaksi masuk berhasil disimpan!');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        
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
                        'harga' => $bahanBaku->harga,
                        'stok_sekarang' => $bahanBaku->stok
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Bahan baku tidak ditemukan'
            ]);
        }

        
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
}
