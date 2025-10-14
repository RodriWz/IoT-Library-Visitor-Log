<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;

class PengunjungController extends Controller
{
    public function index()
    {
        return view('pengunjung.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'tujuan' => 'required',
        ]);

        Pengunjung::create($request->all());

        return redirect('/pengunjung')->with('success', 'Data pengunjung berhasil disimpan!');
    }
}
