<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Suplier;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class TransaksiMasukController extends Controller
{
    public function index()
    {
        $transaksiMasuks = TransaksiMasuk::with(['suplier', 'bahanBaku'])->get();
        return view('transaksi_masuk.index', compact('transaksiMasuks'));
    }

    public function create()
    {
        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_masuk.create', compact('supliers', 'bahan_bakus'));
    }

    public function store(Request $request)
    {
        
        try {
            $validated = $request->validate([
                'id_transaksi' => 'required|unique:transaksi_masuks,id_transaksi',
                'penerima' => 'required',
                'suplier_id' => 'required|exists:supliers,id',
                'bahan_baku_id' => 'required|exists:bahan_bakus,id',
                'stok' => 'required|integer',
                'tanggal_masuk' => 'required|date',
            ]);

            
            TransaksiMasuk::create($validated);
            return redirect()->route('transaksi_masuk.index')->with('success', 'Transaksi masuk berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan transaksi masuk: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        
        $transaksiMasuk = TransaksiMasuk::findOrFail($id);
        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_masuk.edit', compact('transaksiMasuk'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                 'id_transaksi' => 'required|unique:transaksi_masuks,id_transaksi',
                'penerima' => 'required',
                'suplier_id' => 'required|exists:supliers,id',
                'bahan_baku_id' => 'required|exists:bahan_bakus,id',
                'stok' => 'required|integer',
                'tanggal_masuk' => 'required|date',
            ]);

            
            $transaksiMasuk = TransaksiMasuk::findOrFail($id);
            $transaksiMasuk->update($validated);
            return redirect()->route('transaksi_masuk.index')->with('success', 'Transaksi masuk berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi masuk: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        
        try {
            $transaksiMasuk = TransaksiMasuk::findOrFail($id);
            $transaksiMasuk->delete();
            return redirect()->route('transaksi_masuk.index')->with('success', 'Transaksi masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi masuk: ' . $th->getMessage());
        }
    }
}
