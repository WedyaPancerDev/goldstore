<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan - {{ $user->fullname }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card-header {
            background-color: #4CAF50;
            color: white;
            font-size: 1.5em;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            /* Space between header and table */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .status-terpenuhi {
            color: green;
        }

        .status-tidak-terpenuhi {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Laporan Tahunan Penjualan</h1>
    <h2>Nama Pengguna: {{ $user->fullname }}</h2>

    @foreach ($reportData as $year => $data)
        <div class="card">
            <div class="card-header">Tahun: {{ $year }}</div>
            <table>
                <thead>
                    <tr>
                        <th>Cabang</th>
                        <th>Total Target</th>
                        <th>Total Penjualan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $cabang)
                        <tr>
                            <td>{{ $cabang['cabang'] }}</td>
                            <td>Rp {{ number_format($cabang['total_target'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($cabang['total_penjualan'], 0, ',', '.') }}</td>
                            <td
                                class="{{ $cabang['status'] == 'TERPENUHI' ? 'status-terpenuhi' : 'status-tidak-terpenuhi' }}">
                                {{ $cabang['status'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</body>

</html>
