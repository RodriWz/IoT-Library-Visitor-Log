<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; 
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize, WithStyles
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
        return collect($this->data);
    }

    /**
     * LOGIKA STYLING (Warna Header, Border, dan Alignment)
     */
    public function styles(Worksheet $sheet)
    {
        // Hitung baris terakhir (Data + Header 1 baris)
        $lastRow = count($this->data) + 1;

        return [
            // Style untuk Header (Baris 1)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'] // Biru Profesional
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // Border untuk seluruh tabel (A1 sampai kolom C baris terakhir)
            'A1:C' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],

            // Perataan tengah untuk kolom No (A) dan Jumlah (C)
            'A1:A' . $lastRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'C1:C' . $lastRow => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }
    
    public function headings(): array
    {
        // Tetap menggunakan logika Anda sebelumnya agar tidak error
        $labelWaktu = ($this->periode === 'harian') ? 'Tanggal' : 'Bulan';
        return ['No', $labelWaktu, 'Jumlah Pengunjung'];
    }
    
    public function map($row): array
    {
        static $index = 0;
        $index++;
        
        if ($this->periode === 'harian') {
            return [
                $index,
                \Carbon\Carbon::parse($row->tgl)->format('d/m/Y'),
                $row->jumlah . ' Orang'
            ];
        } else {
            return [
                $index,
                isset($row->nama_bulan) ? $row->nama_bulan : (isset($row->bulan) ? $row->bulan : $row->tgl),
                $row->jumlah . ' Orang'
            ];
        }
    }
    
    public function title(): string
    {
        return 'Laporan ' . ucfirst($this->periode);
    }
}