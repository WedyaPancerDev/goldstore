<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Target Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Laporan Target Penjualan</h1>

    <table>
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Bulan</th>
                <th>Target Penjualan</th>
                <th>Total Harga Transaksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $data)
                <tr>
                    <td>{{ $data['user'] }}</td>
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
