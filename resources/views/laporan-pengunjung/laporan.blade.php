@extends('layout.app')

@section('title', 'Laporan Pengunjung')
@section('header-title', 'Laporan Pengunjung')
@section('header-subtitle', 'Laporan Pengunjung Perpustakaan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}?v=1.0">
@endpush

@section('content')

    {{-- ================= FILTER FORM ================= --}}
    <form method="GET" action="{{ route('laporanpengunjung') }}" class="filter-form">
        <label>Periode :</label>
        <select name="periode" id="periode">
            <option value="harian" {{ request('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ request('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
        </select>

        <label>Tahun :</label>
        <select name="tahun" id="tahun">
            @php
                $currentYear = date('Y');
                $startYear = 2020;
            @endphp
            @for ($year = $currentYear; $year >= $startYear; $year--)
                <option value="{{ $year }}" {{ request('tahun', $currentYear) == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>

        <button type="submit" class="btn-tampilkan">Tampilkan Data</button>

        <label>Export :</label>
        <select id="exportType">
            <option value="pdf">PDF</option>
            <option value="xls">XLS</option>
        </select>
        <button type="button" id="btnExport" class="btn-tampilkan">Cetak</button>
    </form>

    {{-- ================= REKAP DATA ================= --}}
    <div class="rekap">
        <h3>
            Daftar Rekapitulasi Perpustakaan Fakultas Kedokteran<br>
            Universitas Hasanuddin
        </h3>

        @if(isset($data) && count($data) > 0)

            {{-- ================= TABLE WRAPPER (SCROLL) ================= --}}
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>

                            @if(request('periode') == 'harian')
                                <th>TANGGAL</th>
                            @endif

                            @if(request('periode') == 'bulanan')
                                <th>BULAN</th>
                            @endif

                            @if(request('periode') == 'tahunan')
                                <th>TAHUN</th>
                            @endif

                            <th>Jumlah Pengunjung</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- HARIAN --}}
                                @if(request('periode') == 'harian')
                                    <td>{{ \Carbon\Carbon::parse($row->tgl)->format('d/m/Y') }}</td>
                                @endif

                                {{-- BULANAN --}}
                                @if(request('periode') == 'bulanan')
                                    <td>{{ $row->nama_bulan }} ({{ $row->bulan }})</td>
                                @endif

                                {{-- TAHUNAN --}}
                                @if(request('periode') == 'tahunan')
                                    <td>{{ $row->tahun }}</td>
                                @endif

                                <td>{{ $row->jumlah }} pengunjung</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ================= TOTAL ================= --}}
            <div class="total">
                <label>Total Pengunjung :</label>
                <input type="text" readonly value="{{ $total ?? 0 }}">
            </div>

            {{-- ================= TTD ================= --}}
            <div class="ttd">
                <div class="left">
                    <p>Makassar, {{ now()->format('d F Y') }}</p>
                    <p>Pengelola Perpustakaan</p>
                    <br><br><br>
                    <p>(_________________)</p>
                </div>
            </div>

        @else
            <div class="alert alert-info">
                <p>Belum ada data pengunjung untuk periode yang dipilih.</p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('btnExport').addEventListener('click', function () {
            const tipe = document.getElementById('exportType').value; // 'pdf' atau 'xls'
            const tahun = document.getElementById('tahun').value;
            const periode = document.getElementById('periode').value;

            // Kita gunakan parameter query '?format=' agar seragam dengan Controller
            window.location.href = `/laporan/export?format=${tipe}&tahun=${tahun}&periode=${periode}`;
        });
    </script>
@endpush