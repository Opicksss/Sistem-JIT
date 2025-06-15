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
            'items.*.stok' => 'required|numeric|',
        ]);

        try {
            DB::beginTransaction();

            
            $bahanBakuIds = collect($request->items)->pluck('bahan_baku_id')->unique();
            $bahanBakus = BahanBaku::lockForUpdate()->whereIn('id', $bahanBakuIds)->get()->keyBy('id');

            
            foreach ($request->items as $item) {
                $bahanBaku = $bahanBakus->get($item['bahan_baku_id']);
                if (!$bahanBaku) {
                    throw new \Exception("Bahan baku dengan ID {$item['bahan_baku_id']} tidak ditemukan");
                }

                if ($bahanBaku->stok < $item['stok']) {
                    throw new \Exception("Stok {$bahanBaku->nama} tidak mencukupi! Stok tersedia: {$bahanBaku->stok}, diminta: {$item['stok']}");
                }
            }

            
            foreach ($request->items as $item) {
                $bahanBaku = $bahanBakus->get($item['bahan_baku_id']);
                $stokAwal = $bahanBaku->stok; 

                
                $bahanBaku->stok -= (float) $item['stok'];
                $bahanBaku->save();

                $sisa = $bahanBaku->stok; 

                
                $biayaPenyimpananPerUnit = $bahanBaku->harga / 2; 
                $totalBiayaPenyimpanan = $sisa * $biayaPenyimpananPerUnit;

                
                TransaksiKeluar::create([
                    'id_transaksi' => $request->id_transaksi,
                    'penerima' => $request->penerima,
                    'suplier_id' => $item['suplier_id'],
                    'bahan_baku_id' => $item['bahan_baku_id'],
                    'stok' => $item['stok'],
                    'stok_awal' => $stokAwal,
                    'sisa' => $sisa,
                    'tanggal_keluar' => $request->tanggal_keluar,
                    'biaya_penyimpanan' => $totalBiayaPenyimpanan,
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

    
    
    
    
    

    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    

    
    

    
    
    
    
    

    
    
    
    
    
    

    
    
    
    
    

    
    
    
    
    
    
    

    
    

    
    
    
    

    
    
    
    
    

    
    
    
    
    
    
    
    
    
    

    

    
    
    
    
    
    
    
    
    

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $transaksi = TransaksiKeluar::lockForUpdate()->findOrFail($id);
            $bahanBaku = BahanBaku::lockForUpdate()->find($transaksi->bahan_baku_id);

            
            $bahanBaku->stok += $transaksi->stok;
            $bahanBaku->save();

            
            $transaksi->delete();

            DB::commit();

            return redirect()->route('transaksi_keluar.index')
                ->with('success', 'Transaksi keluar berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    
    public function sisa()
    {
        $transaksi_keluars = TransaksiKeluar::with(['suplier', 'bahanBaku'])
            ->select('id', 'id_transaksi', 'penerima', 'bahan_baku_id', 'suplier_id', 'stok_awal', 'stok', 'sisa', 'tanggal_keluar')
            ->orderBy('tanggal_keluar', 'desc')
            ->get();

        return view('transaksi_keluar.sisa', compact('transaksi_keluars'));
    }

    
    public function getBahanBaku($id)
    {
        $bahanBaku = BahanBaku::find($id);
        if ($bahanBaku) {
            
            $bahanBaku->refresh();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $bahanBaku->id,
                    'nama' => $bahanBaku->nama,
                    'satuan' => $bahanBaku->satuan,
                    'stok_tersedia' => $bahanBaku->stok,
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

    
    public function checkStok($bahanBakuId, $jumlah)
    {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        if (!$bahanBaku) {
            return response()->json([
                'success' => false,
                'message' => 'Bahan baku tidak ditemukan'
            ]);
        }

        
        $bahanBaku->refresh();
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
