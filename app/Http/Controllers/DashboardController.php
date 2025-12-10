<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik
        $todayVisitors = Pengunjung::whereDate('created_at', today())->count();
        $monthVisitors = Pengunjung::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();
        $totalVisitors = Pengunjung::count();

        // Data untuk chart - 7 hari terakhir
        $dailyVisitors = Pengunjung::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Jika data kosong, buat sample data
        if ($dailyVisitors->isEmpty()) {
            $dailyVisitors = collect();
            for ($i = 6; $i >= 0; $i--) {
                $dailyVisitors->push((object)[
                    'date' => now()->subDays($i)->format('Y-m-d'),
                    'count' => rand(5, 25)
                ]);
            }
        }

        return view('dashboard', compact(
            'todayVisitors',
            'monthVisitors', 
            'totalVisitors',
            'dailyVisitors'
        ));
    }
}