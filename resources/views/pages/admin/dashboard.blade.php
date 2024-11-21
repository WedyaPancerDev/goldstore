@extends('layouts.master')
@section('title')
    Toko Emas - Admin Dashboard
@endsection

@section('content')
    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="staffChartsContainer">
        </div>
    </section>

    <script>
        fetch('/staff-chart-data')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('staffChartsContainer');

                data.forEach(userData => {
                    const chartCol = document.createElement('div');
                    chartCol.classList.add('col-12', 'col-md-6', 'mb-4');

                    chartCol.innerHTML = `
                        <div class="card">
                            <div class="card-header text-center">
                                <h5>${userData.user}</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chart-${userData.user.replace(/\s+/g, '-')}"></canvas>
                            </div>
                        </div>
                    `;
                    container.appendChild(chartCol);

                    const ctx = document.getElementById(`chart-${userData.user.replace(/\s+/g, '-')}`)
                        .getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: userData.months,
                            datasets: [{
                                    label: 'Transaksi Pengeluaran',
                                    data: userData.transaksi_pengeluaran,
                                    backgroundColor: 'rgba(0, 51, 202, 0.72)',
                                    borderWidth: 2
                                },
                                {
                                    label: 'Target Penjualan',
                                    data: userData.target_penjualan,
                                    backgroundColor: 'rgba(202, 59, 0, 0.72)',
                                    borderWidth: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Bulan'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Total (Rp)'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            })
            .catch(error => console.error('Error:', error));
    </script>
@endsection
