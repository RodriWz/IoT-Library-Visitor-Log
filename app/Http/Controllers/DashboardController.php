<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman dashboard (setelah login berhasil)
    public function index()
    {
        return view('dashboard');
    }
}
