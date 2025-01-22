<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Target Penjualan Tahunan</title>
    <style>
        /* General styling for the document */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        /* Title styling */
        h1 {
            text-align: center;
            color: #343a40;
            font-size: 28px;
            margin-bottom: 30px;
        }

        /* Year section styling */
        .year-section {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Year title styling */
        .year-title {
            font-size: 22px;
            color: #495057;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #17a2b8;
            padding-bottom: 5px;
        }

        /* Cabang title styling */
        .cabang-title {
            font-size: 18px;
            color: #495057;
            font-weight: bold;
            margin-top: 10px;
            border-bottom: 2px solid #17a2b8;
            padding-bottom: 5px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ced4da;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #17a2b8;
            color: #ffffff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

    <h1>Laporan Target Penjualan Tahunan</h1>

    <!-- Loop through each year in the report data -->
    @foreach ($reportData as $year => $cabangs)
        <div class="year-section">
            <div class="year-title">Penjualan Tahun {{ $year }}</div>

            <!-- Loop through each cabang in the report data for the year -->
            @foreach ($cabangs as $cabangId => $data)
                <div class="cabang-title">{{ $data[0]['cabang'] }}</div> <!-- Display Cabang Name -->

                <table>
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Total Target</th>
                            <th>Total Penjualan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each user entry in the year and cabang data -->
                        @foreach ($data as $entry)
                            <tr>
                                <td>{{ $entry['user'] }}</td>
                                <td>{{ number_format($entry['total_target'], 0, ',', '.') }}</td>
                                <td>{{ number_format($entry['total_penjualan'], 0, ',', '.') }}</td>
                                <td style="color: {{ $entry['status'] === 'TERPENUHI' ? '#28a745' : '#dc3545' }};">
                                    {{ $entry['status'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endforeach

</body>

</html>
