<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengunjung;
use Carbon\Carbon;

class PengunjungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $prodis = [
            'Pendidikan Kedokteran ',
            'Profesi Dokter',
            'Pendidikan Spesialis',
            'Pendidikan Kedokteran Hewan',
            'Pendidikan Psikologi ',
        ];

        $tujuanList = [
            'Membaca',
            'Belajar',
            'Meminjam Buku',
            'Penelitian',
            'Mengerjakan Tugas',
            'Diskusi Kelompok',
            'Mencari Referensi'
        ];

        $namaDepan = [
            'Ahmad', 'Andi', 'Budi', 'Citra', 'Deni', 'Eka', 'Fajar', 'Gita',
            'Hadi', 'Indra', 'Joko', 'Kartika', 'Lina', 'Maya', 'Nanda', 'Omar',
            'Putri', 'Qori', 'Rina', 'Siti', 'Taufik', 'Umar', 'Vera', 'Wati',
            'Yudi', 'Zahra', 'Agus', 'Bella', 'Chandra', 'Dewi'
        ];

        $namaBelakang = [
            'Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Permana', 'Santoso',
            'Wibowo', 'Hakim', 'Putra', 'Sari', 'Lestari', 'Fitri', 'Hidayat',
            'Nugroho', 'Cahaya', 'Purnama', 'Rahman', 'Abdullah', 'Ibrahim'
        ];

        echo "Generating sample data untuk dashboard...\n";

        // Generate 150 data pengunjung untuk 30 hari terakhir
        for ($i = 0; $i < 150; $i++) {
            // Random tanggal dalam 30 hari terakhir
            $daysAgo = rand(0, 30);
            $date = Carbon::now()->subDays($daysAgo);
            
            // Lebih banyak pengunjung di weekday
            if ($date->isWeekend()) {
                // Weekend: 20% chance skip (lebih sedikit pengunjung)
                if (rand(1, 100) <= 20) {
                    continue;
                }
            }
            
            // Random jam kunjungan (08:00 - 20:00)
            $hour = rand(8, 20);
            $minute = rand(0, 59);
            $date->setTime($hour, $minute);

            $namaLengkap = $namaDepan[array_rand($namaDepan)] . ' ' . 
                          $namaBelakang[array_rand($namaBelakang)];

            Pengunjung::create([
                'nama' => $namaLengkap,
                'nim' => rand(100000, 999999),
                'prodi' => $prodis[array_rand($prodis)],
                'tujuan' => $tujuanList[array_rand($tujuanList)],
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Progress indicator
            if (($i + 1) % 20 == 0) {
                echo "✓ Generated " . ($i + 1) . " records...\n";
            }
        }

        echo "\n✅ Selesai! Total " . Pengunjung::count() . " data pengunjung berhasil dibuat.\n";
        echo "📊 Dashboard sekarang menggunakan data REAL dari database!\n";
    }
}