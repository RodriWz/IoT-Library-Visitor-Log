<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Models\Pengunjung;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'harian');
        $tahun   = $request->get('tahun', date('Y'));

        $data  = $this->getLaporan($periode, $tahun);
        $total = $this->getTotal($tahun);

        return view('laporan-pengunjung.laporan', compact('data', 'total', 'periode', 'tahun'));
    }

    private function getLaporan($periode, $tahun)
    {
        // GANTI 'pengunjungs' MENJADI 'visitors'
        $query = DB::table('visitors')->whereYear('created_at', $tahun);

        if ($periode === 'harian') {
            return $query
                ->select(
                    DB::raw('DATE(created_at) as tgl'),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('tgl')
                ->orderBy('tgl', 'asc')
                ->get();
        }

        if ($periode === 'bulanan') {
            return $query
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as bulan'),
                    DB::raw('MONTHNAME(created_at) as nama_bulan'),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), DB::raw('MONTHNAME(created_at)'))
                ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m") ASC')
                ->get();
        }

        return collect();
    }

    private function getTotal($tahun)
    {
        // GANTI 'pengunjungs' MENJADI 'visitors'
        return DB::table('visitors')
            ->whereYear('created_at', $tahun)
            ->count();
    }
}