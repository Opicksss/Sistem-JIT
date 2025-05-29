<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanBakuController extends Controller
{

    public function index()
    {
        $bahanBakus = BahanBaku::all();
        return view('material.index', compact('bahanBakus'));
    }


    public function create()
    {
        return view('material.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_bahan_baku' => 'required|unique:bahan_bakus',
                'nama'          => 'required',
                'jenis'         => 'required',
                'satuan'        => 'required',
                'harga'         => 'required|numeric',
                'stok'          => 'required|integer',
                'gambar'        => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('gambar_bahan', 'public');
                $validated['gambar'] =  $gambar;
            }

            BahanBaku::create($validated);


            return redirect()->route('bahanBaku.index')->with('success', 'Bahan baku berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan bahan baku.');
        }
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        return view('material.edit', compact('bahanBaku'));
    }


    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama'   => 'required',
                'jenis'  => 'required',
                'satuan' => 'required',
                'harga'  => 'required|numeric',
                'stok'   => 'required|integer',
                'gambar' => 'nullable|image|max:2048',
            ]);

            $bahanBaku = BahanBaku::findOrFail($id);

            if ($request->hasFile('gambar')) {
                if ($bahanBaku->gambar && Storage::disk('public')->exists($bahanBaku->gambar)) {
                    Storage::disk('public')->delete($bahanBaku->gambar);
                }
                $gambarBaru = $request->file('gambar')->store('gambar_bahan', 'public');
                $validated['gambar'] = $gambarBaru;
            }

            $bahanBaku->update($validated);

            return redirect()->route('bahanBaku.index')->with('success', 'Bahan baku berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui bahan baku.');
        }
    }


    public function destroy($id)
    {
        try {
            $bahanBaku = BahanBaku::findOrFail($id);
            $bahanBaku->delete();

            return redirect()->route('bahanBaku.index')->with('success', 'Bahan baku berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus bahan baku.');
        }
    }
}
