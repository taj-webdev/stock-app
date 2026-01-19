<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h3 { text-align: center; margin-bottom: 0; }
        .info { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h3>Laporan Barang Keluar</h3>
    <div class="info">
        <small>
            Periode: {{ $from ? $from : '-' }} s/d {{ $to ? $to : '-' }} <br>
            Dicetak: {{ date('d-m-Y H:i') }}
        </small>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Customer</th>
                <th>Qty</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->barang->nama ?? '-' }}</td>
                    <td>{{ $row->customer->nama ?? '-' }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                    <td>{{ $row->user->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
