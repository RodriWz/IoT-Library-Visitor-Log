<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jumlah Pengunjung</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tgl)->format('d/m/Y') }}</td>
                <td>{{ $row->jumlah }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><strong>Total Pengunjung</strong></td>
            <td><strong>{{ $total }}</strong></td>
        </tr>
    </tfoot>
</table>
