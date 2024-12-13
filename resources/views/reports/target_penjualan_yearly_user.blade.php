<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan - {{ $user->fullname }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Laporan Tahunan Penjualan - {{ $user->fullname }}</h1>
    <p>Periode: {{ now()->year }}</p>

    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Total Target</th>
                <th>Total Penjualan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $year => $data)
                <tr>
                    <td>{{ $year }}</td>
                    <td>{{ number_format($data['total_target'], 0, ',', '.') }}</td>
                    <td>{{ number_format($data['total_penjualan'], 0, ',', '.') }}</td>
                    <td>{{ $data['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
