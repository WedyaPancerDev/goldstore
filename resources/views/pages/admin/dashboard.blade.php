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
                    const userSection = document.createElement('div');
                    userSection.classList.add('col-12', 'mb-4');

                    let yearlyChart = '';
                    // Hanya tampilkan chart yearly jika data tersedia
                    if (userData.yearly.years.length > 0) {
                        yearlyChart = `
                            <div class="col-md-6">
                                <h5 class="text-center">Chart Pertahun</h5>
                                <canvas id="chart-yearly-${userData.user.replace(/\s+/g, '-')}"></canvas>
                            </div>
                        `;
                    }

                    userSection.innerHTML = `
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>${userData.user}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-center">Chart Perbulan</h5>
                                        <canvas id="chart-monthly-${userData.user.replace(/\s+/g, '-')}"></canvas>
                                    </div>
                                    ${yearlyChart}
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(userSection);

                    // --- Render Chart Perbulan ---
                    const ctxMonthly = document.getElementById(
                        `chart-monthly-${userData.user.replace(/\s+/g, '-')}`).getContext('2d');
                    new Chart(ctxMonthly, {
                        type: 'bar',
                        data: {
                            labels: userData.monthly.months,
                            datasets: [{
                                    label: 'Transaksi Pengeluaran',
                                    data: userData.monthly.transaksi_pengeluaran,
                                    backgroundColor: 'rgba(0, 51, 202, 0.72)',
                                },
                                {
                                    label: 'Target Penjualan',
                                    data: userData.monthly.target_penjualan,
                                    backgroundColor: 'rgba(202, 59, 0, 0.72)',
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
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
                                },
                            },
                        },
                    });

                    // --- Render Chart Pertahun ---
                    if (userData.yearly.years.length > 0) {
                        const ctxYearly = document.getElementById(
                            `chart-yearly-${userData.user.replace(/\s+/g, '-')}`).getContext('2d');
                        new Chart(ctxYearly, {
                            type: 'bar',
                            data: {
                                labels: userData.yearly.years,
                                datasets: [{
                                        label: 'Transaksi Pengeluaran',
                                        data: userData.yearly.transaksi_pengeluaran,
                                        backgroundColor: 'rgba(0, 102, 255, 0.72)',
                                    },
                                    {
                                        label: 'Target Penjualan',
                                        data: userData.yearly.target_penjualan,
                                        backgroundColor: 'rgba(255, 102, 0, 0.72)',
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Tahun'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total (Rp)'
                                        },
                                        beginAtZero: true
                                    },
                                },
                            },
                        });
                    }
                });
            })
            .catch(error => console.error('Error:', error));
    </script>
@endsection
