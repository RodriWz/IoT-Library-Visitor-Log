<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;

class PengunjungController extends Controller
{
    public function index()
    {
        $pengunjungs = Pengunjung::orderBy('created_at', 'desc')->get();
        return view('daftar-pengunjung.daftarpengunjung', compact('pengunjungs'));
    }

    public function create()
    {
        return view('form-pengunjung.formpengunjung');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:500',
        ]);

        Pengunjung::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'tujuan' => $request->tujuan,
        ]);

        return redirect()->route('formpengunjung')
                         ->with('success', 'Data pengunjung berhasil disimpan!');
    }

    public function dashboard()
    {
        $todayVisitors = Pengunjung::whereDate('created_at', today())->count();
        $monthVisitors = Pengunjung::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count();
        $totalVisitors = Pengunjung::count();

        $dailyVisitors = Pengunjung::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('dashboard.dashboard', compact(
            'todayVisitors',
            'monthVisitors',
            'totalVisitors',
            'dailyVisitors'
        ));
    }
}
