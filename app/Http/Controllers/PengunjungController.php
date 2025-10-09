<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        return view('pengunjung');
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

        return redirect()->back()->with('success', 'Data pengunjung berhasil disimpan!');
    }
}