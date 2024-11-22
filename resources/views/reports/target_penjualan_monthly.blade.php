<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Target Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Laporan Target Penjualan Bulanan</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Bulan</th>
                    <th>Target Penjualan</th>
                    <th>Total Penjualan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['user'] }}</td>
                        <td>{{ $data['bulan'] }}</td>
                        <td>Rp {{ number_format($data['target'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data['total_price'], 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $data['status'] == 'TERPENUHI' ? 'badge-success' : 'badge-danger' }}">
                                {{ $data['status'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
