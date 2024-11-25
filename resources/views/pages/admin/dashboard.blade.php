@extends('layouts.master')
@section('title')
    Toko Emas - Admin Dashboard
@endsection

@section('content')
    <section class="container container__bscreen mt-5">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Dashboard</h4>
                    <div class="d-flex gap-2 w-50">
                        <button id="btn-monthly" class="btn btn-primary">Tampilkan Chart Perbulan</button>
                        <button id="btn-yearly" class="btn btn-secondary">Tampilkan Chart Pertahun</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" id="staffChartsContainer">
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnMonthly = document.getElementById('btn-monthly');
            const btnYearly = document.getElementById('btn-yearly');
            const container = document.getElementById('staffChartsContainer');

            fetch('/staff-chart-data')
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    renderCharts(data, 'monthly');

                    btnMonthly.addEventListener('click', () => {
                        container.innerHTML = '';
                        renderCharts(data, 'monthly');
                        btnMonthly.classList.add('btn-primary');
                        btnMonthly.classList.remove('btn-secondary');
                        btnYearly.classList.add('btn-secondary');
                        btnYearly.classList.remove('btn-primary');
                    });

                    btnYearly.addEventListener('click', () => {
                        container.innerHTML = '';
                        renderCharts(data, 'yearly');
                        btnYearly.classList.add('btn-primary');
                        btnYearly.classList.remove('btn-secondary');
                        btnMonthly.classList.add('btn-secondary');
                        btnMonthly.classList.remove('btn-primary');
                    });
                })
                .catch(error => console.error('Error:', error));

            function renderCharts(data, type) {
                data.forEach(userData => {
                    const userSection = document.createElement('div');
                    userSection.classList.add('col-12', 'col-md-6', 'mb-5');

                    if (type === 'monthly') {
                        userSection.innerHTML = `
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4>${userData.user}</h4>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center">Chart Perbulan</h5>
                                    <div style="position: relative; height: 400px;"> <!-- Added height for proper canvas display -->
                                        <canvas id="chart-monthly-${userData.user.replace(/\s+/g, '-')}"></canvas>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(userSection);

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
                                        position: 'top',
                                    },
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Bulan',
                                        },
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total (Rp)',
                                        },
                                        beginAtZero: true,
                                    },
                                },
                            },
                        });
                    }

                    if (type === 'yearly' && userData.yearly.years.length > 0) {
                        userSection.innerHTML = `
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4>${userData.user}</h4>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center">Chart Pertahun</h5>
                                    <div style="position: relative; height: 400px;"> <!-- Added height for proper canvas display -->
                                        <canvas id="chart-yearly-${userData.user.replace(/\s+/g, '-')}"></canvas>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(userSection);

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
                                        position: 'top',
                                    },
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Tahun',
                                        },
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total (Rp)',
                                        },
                                        beginAtZero: true,
                                    },
                                },
                            },
                        });
                    }
                });
            }
        });
    </script>
@endsection
