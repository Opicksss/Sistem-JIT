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

            // Ambil semua bahan baku yang terlibat dengan lock
            $bahanBakuIds = collect($request->items)->pluck('bahan_baku_id')->unique();
            $bahanBakus = BahanBaku::lockForUpdate()->whereIn('id', $bahanBakuIds)->get()->keyBy('id');

            // Validasi stok tersedia untuk setiap item dengan data yang sudah di-lock
            foreach ($request->items as $item) {
                $bahanBaku = $bahanBakus->get($item['bahan_baku_id']);
                if (!$bahanBaku) {
                    throw new \Exception("Bahan baku dengan ID {$item['bahan_baku_id']} tidak ditemukan");
                }
                
                if ($bahanBaku->stok < $item['stok']) {
                    throw new \Exception("Stok {$bahanBaku->nama} tidak mencukupi! Stok tersedia: {$bahanBaku->stok}, diminta: {$item['stok']}");
                }
            }

            // Proses setiap item dan kurangi stok
            foreach ($request->items as $item) {
                $bahanBaku = $bahanBakus->get($item['bahan_baku_id']);
                $stokAwal = $bahanBaku->stok; // Stok sebelum dikurangi
                
                // Kurangi stok terlebih dahulu
                $bahanBaku->stok -= $item['stok'];
                $bahanBaku->save();
                
                $sisa = $bahanBaku->stok; // Stok setelah dikurangi

                // Buat transaksi keluar
                TransaksiKeluar::create([
                    'id_transaksi' => $request->id_transaksi,
                    'penerima' => $request->penerima,
                    'suplier_id' => $item['suplier_id'],
                    'bahan_baku_id' => $item['bahan_baku_id'],
                    'stok' => $item['stok'],
                    'stok_awal' => $stokAwal,
                    'sisa' => $sisa,
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

    public function show($id)
    {
        $transaksi_keluar = TransaksiKeluar::with(['suplier', 'bahanBaku'])->findOrFail($id);
        return view('transaksi_keluar.show', compact('transaksi_keluar'));
    }

    public function edit($id)
    {
        $transaksi_keluar = TransaksiKeluar::findOrFail($id);
        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_keluar.edit', compact('transaksi_keluar', 'supliers', 'bahan_bakus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penerima' => 'required|string',
            'tanggal_keluar' => 'required|date',
            'suplier_id' => 'required|exists:supliers,id',
            'bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'stok' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $transaksi = TransaksiKeluar::lockForUpdate()->findOrFail($id);
            $oldStok = $transaksi->stok;
            $oldBahanBakuId = $transaksi->bahan_baku_id;
            $newStok = $request->stok;
            $newBahanBakuId = $request->bahan_baku_id;

            // Jika bahan baku berbeda, perlu handle 2 bahan baku
            if ($oldBahanBakuId != $newBahanBakuId) {
                // Kembalikan stok ke bahan baku lama
                $oldBahanBaku = BahanBaku::lockForUpdate()->find($oldBahanBakuId);
                $oldBahanBaku->stok += $oldStok;
                $oldBahanBaku->save();

                // Ambil bahan baku baru dan validasi stok
                $newBahanBaku = BahanBaku::lockForUpdate()->find($newBahanBakuId);
                if ($newBahanBaku->stok < $newStok) {
                    throw new \Exception("Stok {$newBahanBaku->nama} tidak mencukupi! Stok tersedia: {$newBahanBaku->stok}, diminta: {$newStok}");
                }

                $stokAwal = $newBahanBaku->stok;
                $newBahanBaku->stok -= $newStok;
                $newBahanBaku->save();
                $sisa = $newBahanBaku->stok;
            } else {
                // Bahan baku sama, hanya update jumlah stok
                $bahanBaku = BahanBaku::lockForUpdate()->find($oldBahanBakuId);
                
                // Kembalikan stok lama terlebih dahulu
                $bahanBaku->stok += $oldStok;
                
                // Validasi stok baru
                if ($bahanBaku->stok < $newStok) {
                    throw new \Exception("Stok {$bahanBaku->nama} tidak mencukupi! Stok tersedia: {$bahanBaku->stok}, diminta: {$newStok}");
                }

                $stokAwal = $bahanBaku->stok;
                $bahanBaku->stok -= $newStok;
                $bahanBaku->save();
                $sisa = $bahanBaku->stok;
            }

            // Update transaksi
            $transaksi->update([
                'penerima' => $request->penerima,
                'suplier_id' => $request->suplier_id,
                'bahan_baku_id' => $newBahanBakuId,
                'stok' => $newStok,
                'stok_awal' => $stokAwal,
                'sisa' => $sisa,
                'tanggal_keluar' => $request->tanggal_keluar,
            ]);

            DB::commit();

            return redirect()->route('transaksi_keluar.index')
                ->with('success', 'Transaksi keluar berhasil diupdate!');
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

            // Kembalikan stok ke bahan baku
            $bahanBaku->stok += $transaksi->stok;
            $bahanBaku->save();

            // Hapus transaksi
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

    // Halaman Sisa Stok
    public function sisa()
    {
        $transaksi_keluars = TransaksiKeluar::with(['suplier', 'bahanBaku'])
            ->select('id', 'id_transaksi', 'penerima', 'bahan_baku_id', 'suplier_id', 'stok_awal', 'stok', 'sisa', 'tanggal_keluar')
            ->orderBy('tanggal_keluar', 'desc')
            ->get();

        return view('transaksi_keluar.sisa', compact('transaksi_keluars'));
    }

    // API untuk mendapatkan data bahan baku dengan stok real-time
    public function getBahanBaku($id)
    {
        $bahanBaku = BahanBaku::find($id);
        if ($bahanBaku) {
            // Refresh untuk mendapatkan stok terbaru
            $bahanBaku->refresh();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $bahanBaku->id,
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

    // API untuk cek stok tersedia dengan data real-time
    public function checkStok($bahanBakuId, $jumlah)
    {
        $bahanBaku = BahanBaku::find($bahanBakuId);
        if (!$bahanBaku) {
            return response()->json([
                'success' => false,
                'message' => 'Bahan baku tidak ditemukan'
            ]);
        }

        // Refresh untuk mendapatkan stok terbaru
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