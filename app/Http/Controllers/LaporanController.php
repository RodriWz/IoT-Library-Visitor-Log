<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'harian');
        $tahun   = $request->get('tahun', date('Y'));

        $data  = $this->getLaporan($periode, $tahun);
        $total = $this->getTotal($tahun);

        return view('laporan', compact('data', 'total', 'periode', 'tahun'));
    }

    public function export(Request $request, $tipe)
    {
        $periode = $request->get('periode', 'harian');
        $tahun   = $request->get('tahun', date('Y'));

        $data  = $this->getLaporan($periode, $tahun);
        $total = $this->getTotal($tahun);

        if ($tipe == 'pdf') {
            $pdf = Pdf::loadView('laporan_pdf', [
                'data' => $data,
                'total' => $total,
                'periode' => $periode,
                'tahun' => $tahun
            ])->setPaper('A4', 'portrait');

            return $pdf->download("laporan_pengunjung_{$periode}_{$tahun}.pdf");
        }

        if ($tipe == 'xls') {
            return Excel::download(
                new LaporanExport($data, $total, $periode, $tahun),
                "laporan_pengunjung_{$periode}_{$tahun}.xlsx"
            );
        }

        return back()->with('error', 'Format export tidak valid');
    }
    private function getLaporan($periode, $tahun)
    {
        $query = DB::table('pengunjungs')
            ->whereYear('created_at', $tahun);

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


        // BULANAN
        if ($periode === 'bulanan') {
            return $query
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as bulan'),
                    DB::raw('MONTHNAME(created_at) as nama_bulan'),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m") ASC')
                ->get();
        }

        // TAHUNAN
        if ($periode === 'tahunan') {
            return $query
                ->select(
                    DB::raw('YEAR(created_at) as tahun'),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderByRaw('YEAR(created_at) ASC')
                ->get();
        }

        return collect();
    }


    /* ============================================================
       FUNGSI TOTAL (HARUS TERPISAH)
       ============================================================ */
    private function getTotal($tahun)
    {
        return DB::table('pengunjungs')
            ->whereYear('created_at', $tahun)
            ->count();
    }
}
