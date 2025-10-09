<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // tambahkan ini kalau nanti ambil data dari DB

class DashboardController extends Controller
{
    public function index()
    {
        // Sementara, isi dengan data statis dulu (bisa kamu ganti ambil dari database nanti)
        $dailyVisitors = 125;
        $monthlyVisitors = 3200;
        $yearlyVisitors = 42000;

        // Kirim semua variabel ke view
        return view('dashboard', compact('dailyVisitors', 'monthlyVisitors', 'yearlyVisitors'));
    }
}
