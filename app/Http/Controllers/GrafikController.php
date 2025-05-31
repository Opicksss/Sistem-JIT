<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrafikController extends Controller
{
    public function masuk(Request $request)
    {
        return view('grafik.masuk');
    }

    public function keluar(Request $request)
    {
        return view('grafik.keluar');
    }
}
