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
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-header {
            font-size: 1.5em;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status-TERPENUHI {
            color: green;
            font-weight: bold;
        }

        .status-TIDAK_TERPENUHI {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Laporan Target Penjualan Bulanan</h1>

    @foreach ($reportData as $cabang)
        <div class="card">
            <div class="card-header">
                {{ $cabang['cabang'] }}
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Bulan</th>
                            <th>Target</th>
                            <th>Total Penjualan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cabang['data'] as $data)
                            <tr>
                                <td>{{ $data['user'] }}</td>
                                <td>{{ $data['bulan'] }}</td>
                                <td>{{ number_format($data['target'], 2) }}</td>
                                <td>{{ number_format($data['total_price'], 2) }}</td>
                                <td
                                    class="{{ $data['status'] === 'TERPENUHI' ? 'status-TERPENUHI' : 'status-TIDAK_TERPENUHI' }}">
                                    {{ $data['status'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</body>

</html>
