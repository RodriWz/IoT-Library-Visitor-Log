<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim', 
        'prodi',
        'tujuan'
        // created_at dan updated_at otomatis ada
    ];

    // Tidak perlu menambahkan apa-apa untuk created_at
    // Laravel otomatis handle timestamps
}