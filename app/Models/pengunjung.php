<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    // Paksa menggunakan tabel visitors
    protected $table = 'visitors';

    protected $guarded = [];
}
