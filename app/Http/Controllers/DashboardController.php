<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== STATISTIK UTAMA (3 CARD) =====
        $todayVisitors = Pengunjung::whereDate('created_at', today())->count();
        $monthVisitors = Pengunjung::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count();
        $totalVisitors = Pengunjung::count();

        // ===== PERUBAHAN PERSENTASE =====
        $todayChange = $this->getTodayChange();
        $monthChange = $this->getMonthChange();

        // ===== DATA CHART - 7 Hari Terakhir =====
        $dailyVisitors = $this->getDailyVisitorsData();

        // ===== DISTRIBUSI PROGRAM STUDI =====
        $prodiDistribution = $this->getProdiDistribution();

        // ===== WARNA MAROON BERTINGKAT UNTUK CHART =====
        $colors = [
            '#8B0000', // maroon-700 (Base)
            '#A52A2A', // maroon-600
            '#B22222', // maroon-500
            '#CD5C5C', // maroon-400
            '#DC143C', // maroon-300
            '#F08080', // maroon-200
            '#FFB6C1', // maroon-100
            '#6B0505'  // maroon-800
        ];

        return view('dashboard.dashboard', compact(
            'todayVisitors',
            'monthVisitors',
            'totalVisitors',
            'todayChange',
            'monthChange',
            'dailyVisitors',
            'prodiDistribution',
            'colors'
        ));
    }

    /**
     * Get data pengunjung 7 hari terakhir
     */
    private function getDailyVisitorsData()
    {
        $dailyVisitors = Pengunjung::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Jika data kosong, generate sample data
        if ($dailyVisitors->isEmpty()) {
            $dailyVisitors = collect();
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dailyVisitors->push((object)[
                    'date'     => $date->format('Y-m-d'),
                    'count'    => $this->generateSampleCount($date),
                    'day_name' => $date->locale('id')->translatedFormat('l')
                ]);
            }
        } else {
            // Tambahkan nama hari
            $dailyVisitors = $dailyVisitors->map(function ($item) {
                $date = Carbon::parse($item->date);
                $item->day_name = $date->locale('id')->translatedFormat('l');
                return $item;
            });
        }

        return $dailyVisitors;
    }

    /**
     * Get distribusi pengunjung per program studi
     */
    private function getProdiDistribution()
    {
        $prodis = Pengunjung::selectRaw('prodi, COUNT(*) as count')
            ->whereNotNull('prodi')
            ->where('prodi', '!=', '')
            ->groupBy('prodi')
            ->orderBy('count', 'desc')
            ->limit(6) // Ambil 6 prodi terbanyak (sesuai tampilan)
            ->get();

        // Jika data kosong, generate sample data
        if ($prodis->isEmpty()) {
            $prodis = collect([
                (object)['prodi' => 'Teknik Informatika', 'count' => 45],
                (object)['prodi' => 'Sistem Informasi', 'count' => 35],
                (object)['prodi' => 'Manajemen', 'count' => 25],
                (object)['prodi' => 'Akuntansi', 'count' => 20],
                (object)['prodi' => 'Kedokteran', 'count' => 18],
                (object)['prodi' => 'Hukum', 'count' => 15],
            ]);
        }

        return $prodis;
    }

    /**
     * Hitung persentase perubahan pengunjung hari ini vs kemarin
     */
    private function getTodayChange()
    {
        $todayCount = Pengunjung::whereDate('created_at', today())->count();
        $yesterdayCount = Pengunjung::whereDate('created_at', Carbon::yesterday())->count();
        
        if ($yesterdayCount > 0) {
            return round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1);
        }
        
        return $todayCount > 0 ? 100 : 0;
    }

    /**
     * Hitung persentase perubahan pengunjung bulan ini vs bulan lalu
     */
    private function getMonthChange()
    {
        $currentMonthCount = Pengunjung::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthCount = Pengunjung::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        
        if ($lastMonthCount > 0) {
            return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1);
        }
        
        return $currentMonthCount > 0 ? 100 : 0;
    }

    /**
     * Generate sample count untuk demo (weekday vs weekend)
     */
    private function generateSampleCount($date)
    {
        if ($date && $date->isWeekend()) {
            return rand(5, 15); // Weekend: lebih sedikit
        }
        return rand(15, 35); // Weekday: lebih banyak
    }

    /**
     * Get chart data berdasarkan period (AJAX endpoint)
     */
    public function getChartData(Request $request)
    {
        $period = $request->query('period', 'week');
        
        $data = match($period) {
            'week' => $this->getWeeklyData(),
            'month' => $this->getMonthlyData(),
            'year' => $this->getYearlyData(),
            default => $this->getWeeklyData()
        };
        
        return response()->json($data);
    }

    /**
     * Get data untuk 7 hari terakhir
     */
    private function getWeeklyData()
    {
        $data = Pengunjung::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = [];
        $counts = [];

        if ($data->isEmpty()) {
            // Generate sample data untuk 7 hari
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->locale('id')->translatedFormat('l');
                $counts[] = $this->generateSampleCount($date);
            }
        } else {
            foreach ($data as $item) {
                $date = Carbon::parse($item->date);
                $labels[] = $date->locale('id')->translatedFormat('l');
                $counts[] = $item->count;
            }
        }

        return compact('labels', 'counts');
    }

    /**
     * Get data untuk 30 hari terakhir (per minggu)
     */
    private function getMonthlyData()
    {
        $weeks = [];
        $counts = [];
        
        // Group by week untuk 4 minggu terakhir
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $count = Pengunjung::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            
            $weeks[] = 'Minggu ' . (4 - $i);
            $counts[] = $count > 0 ? $count : rand(20, 50);
        }

        return ['labels' => $weeks, 'counts' => $counts];
    }

    /**
     * Get data untuk 12 bulan terakhir
     */
    private function getYearlyData()
    {
        $months = [];
        $counts = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Pengunjung::whereMonth('created_at', $date->month)
                              ->whereYear('created_at', $date->year)
                              ->count();
            
            $months[] = $date->locale('id')->translatedFormat('M');
            $counts[] = $count > 0 ? $count : rand(50, 150);
        }

        return ['labels' => $months, 'counts' => $counts];
    }
}