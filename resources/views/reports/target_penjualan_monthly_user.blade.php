<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - {{ $user->fullname }}</title>
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
    <h1>Laporan Bulanan Penjualan - {{ $user->fullname }}</h1>
    <p>Periode: {{ now()->year }}</p>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Target</th>
                <th>Total Penjualan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
                <tr>
                    <td>{{ $data['bulan'] }}</td>
                    <td>{{ number_format($data['target'], 0, ',', '.') }}</td>
                    <td>{{ number_format($data['total_price'], 0, ',', '.') }}</td>
                    <td>{{ $data['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
