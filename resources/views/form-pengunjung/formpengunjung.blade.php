@extends('layout.app')

@section('title', 'Form Pengunjung')
@section('header-title', 'Form Pengunjung')
@section('header-subtitle', 'Mohon isi data dengan benar')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form.pengunjung.css') }}?v=1.0">
@endpush

@section('content')
    {{-- Notifikasi dihapus dari sini karena sudah ada di layout utama (melayang) --}}

    <div class="form-container">
        <div class="add-icon">
            <img src="{{ asset('icon/user.png') }}" alt="User Icon" class="add-icon-img">
            Tambah data baru
        </div>

        <form action="{{ route('pengunjung.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Pengunjung" required>
            </div>

            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" placeholder="Masukkan NIM Pengunjung" required>
            </div>

            <div class="form-group">
                <label for="prodi">Prodi</label>
                <input type="text" id="prodi" name="prodi" placeholder="Masukkan Prodi Pengunjung" required>
            </div>

            <div class="form-group">
                <label for="tujuan">Tujuan</label>
                <input type="text" id="tujuan" name="tujuan" placeholder="Masukkan Tujuan Pengunjung" required>
            </div>

            <button type="submit" class="submit-btn">Daftar</button>
        </form>
    </div>
@endsection