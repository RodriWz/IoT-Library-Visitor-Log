@extends('layout.app')

@section('header-title', 'Daftar Pengunjung')
@section('header-subtitle', 'Pencatatan data pengunjung perpustakaan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/daftarpengunjung.css') }}?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')

    <div class="table-container">
        <div class="table-header">
            <div class="header-title">Daftar Tabel Pengunjung</div>
            <input type="text" placeholder="Cari Data" class="search-input">
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal/bulan/tahun</th>
                        <th>Nama pengunjung</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengunjungs as $p)
                        <tr data-id="{{ $p->id }}">
                            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nim }}</td>
                            <td>{{ $p->prodi }}</td>
                            <td>{{ $p->tujuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <button id="editButton" class="btn-icon btn-edit" title="Edit Data">
                <i class="fas fa-edit"></i>
            </button>
            <button id="deleteButton" class="btn-icon btn-delete" title="Hapus Data">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>

    @include('modals.modals')

@endsection

@push('scripts')
    <script src="{{ asset('js/daftarpengunjung.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
@endpush