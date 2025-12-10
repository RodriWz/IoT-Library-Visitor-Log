<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengunjung</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .total { font-weight: bold; margin-top: 20px; }
        .ttd { margin-top: 50px; }
        .ttd p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Daftar Rekapitulasi Perpustakaan Fakultas Kedokteran<br>Universitas Hasanuddin</h3>
    </div>
    
    <div style="margin-bottom: 20px;">
        <p><strong>Periode:</strong> {{ ucfirst($periode) }} {{ $tahun }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>NO</th>
                @if($periode === 'harian')
                    <th>TANGGAL</th>
                @else
                    <th>BULAN</th>
                @endif
                <th>Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                @if($periode === 'harian')
                    <td>{{ \Carbon\Carbon::parse($item->tgl)->format('d/m/Y') }}</td>
                @else
                    <td>
                        @if(isset($item->bulan))
                            {{ $item->bulan }}
                        @else
                            {{ \Carbon\Carbon::parse($item->tgl)->format('F Y') }}
                        @endif
                    </td>
                @endif
                <td>{{ $item->jumlah }} pengunjung</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        <p>Total Pengunjung: {{ $total }}</p>
    </div>
    
    <div class="ttd">
        <div style="float: right; width: 300px;">
            <p>Makassar, {{ now()->format('d F Y') }}</p>
            <p>Pengelola Perpustakaan</p>
            <br><br><br>
            <p>(_________________)</p>
        </div>
    </div>
</body>
</html>