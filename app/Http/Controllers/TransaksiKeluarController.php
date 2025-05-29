<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Suplier;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class TransaksiKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiKeluars = TransaksiKeluar::with(['suplier', 'bahanBaku'])->get();
        return view('transaksi_keluar.index', compact('transaksiKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_keluar.create', compact('supliers', 'bahan_bakus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'penerima' => 'required',
                'suplier_id' => 'required|exists:supliers,id',
                'bahan_baku_id' => 'required|exists:bahan_bakus,id',
                'stok' => 'required|integer',
                'tanggal_keluar' => 'required|date',
            ]);
            TransaksiKeluar::create($validated);
            return redirect()->route('transaksi_keluar.index')->with('success', 'Transaksi keluar berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan transaksi keluar: ' . $th->getMessage());
        }
    }

 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiKeluar $transaksiKeluar)
    {

        $supliers = Suplier::all();
        $bahan_bakus = BahanBaku::all();
        return view('transaksi_keluar.edit', compact('transaksiKeluar', 'supliers', 'bahan_bakus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiKeluar $transaksiKeluar)
    {
        try {
            $validated = $request->validate([
                'penerima' => 'required',
                'suplier_id' => 'required|exists:supliers,id',
                'bahan_baku_id' => 'required|exists:bahan_bakus,id',
                'stok' => 'required|integer',
                'tanggal_keluar' => 'required|date',
            ]);
            $transaksiKeluar->update($validated);
            return redirect()->route('transaksi_keluar.index')->with('success', 'Transaksi keluar berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi keluar: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKeluar $transaksiKeluar)
    {
        //
    }
}
