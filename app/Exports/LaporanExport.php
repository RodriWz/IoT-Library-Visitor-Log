<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $data;
    protected $total;
    protected $periode;
    protected $tahun;
    
    public function __construct($data, $total, $periode, $tahun)
    {
        $this->data = $data;
        $this->total = $total;
        $this->periode = $periode;
        $this->tahun = $tahun;
    }
    
    public function collection()
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        if ($this->periode === 'harian') {
            return ['No', 'Tanggal', 'Jumlah Pengunjung'];
        } else {
            return ['No', 'Bulan', 'Jumlah Pengunjung'];
        }
    }
    
    public function map($row): array
    {
        static $index = 0;
        $index++;
        
        if ($this->periode === 'harian') {
            return [
                $index,
                \Carbon\Carbon::parse($row->tgl     )->format('d/m/Y'),
                $row->jumlah
            ];
        } else {
            return [
                $index,
                isset($row->bulan) ? $row->bulan : \Carbon\Carbon::parse($row->tanggal)->format('F Y'),
                $row->jumlah
            ];
        }
    }
    
    public function title(): string
    {
        return 'Laporan ' . ucfirst($this->periode);
    }
}