<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $suppliers = Suplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        
       try {
            $validated = $request->validate([
                'id_suplier' => 'required|unique:supliers',
                'nama'     => 'required',
                'alamat'   => 'required',
                'telepon'  => 'required',
                'kota'     => 'required',
                'provinsi' => 'required',
            ]);

            
            Suplier::create($validated);

            return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Validation failed: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $supplier = Suplier::findOrFail($id);
       
        
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validated = $request->validate([
                'id_suplier' => 'required|unique:supliers,id_suplier,' . $id,
                'nama'     => 'required',
                'alamat'   => 'required',
                'telepon'  => 'required',
                'kota'     => 'required',
                'provinsi' => 'required',
            ]);

            
            $supplier = Suplier::findOrFail($id);
            $supplier->update($validated);

            return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Validation failed: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        
        try {
            $supplier = Suplier::findOrFail($id);
            $supplier->delete();

            return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Deletion failed: ' . $th->getMessage());
        }
    }

}
