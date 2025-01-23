<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan - {{ $user->fullname }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .status-TERPENUHI {
            color: green;
        }

        .status-TIDAK-TERPENUHI {
            color: red;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <h1>Laporan Bulanan - {{ $user->fullname }}</h1>

    @foreach ($reportData as $cabangId => $cabangData)
        <h2>{{ $cabangData[0]['cabang'] }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Target</th>
                    <th>Total Penjualan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cabangData as $data)
                    <tr>
                        <td>{{ $data['bulan'] }}</td>
                        <td>{{ number_format($data['target'], 2, ',', '.') }}</td>
                        <td>{{ number_format($data['total_price'], 2, ',', '.') }}</td>
                        <td class="status-{{ str_replace(' ', '-', $data['status']) }}">{{ $data['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

</body>

</html>
