@extends('layouts.master')
@section('title')
    Toko Emas - akuntan Dashboard
@endsection

@section('content')
<section class="container container__bscreen mt-5">
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-0">Semua Transaksi</h4>
            </div>
        </div>
    </div>

    <div class="row" id="chartsContainer">
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('chartsContainer');

        fetch('/getAllTransaksiandTarget')
            .then(response => response.json())
            .then(data => {
                container.innerHTML = '';
                renderCharts(data);
            })
            .catch(error => console.error('Error:', error));

        function renderCharts(data) {
            data.forEach(userData => {
                const userSection = document.createElement('div');
                userSection.classList.add('col-12', 'col-md-6', 'mb-5');

                userSection.innerHTML = `
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>${userData.user}</h4>
                        </div>
                        <div class="card-body";>
                            <h5 class="text-center">Total Transaksi</h5>
                            <div style="position: relative; height: 400px;"> <!-- Added height for proper canvas display -->
                                <canvas id="chart-${userData.user.replace(/\s+/g, '-')}"></canvas>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(userSection);

                const ctx = document.getElementById(`chart-${userData.user.replace(/\s+/g, '-')}`).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Transaksi Pengeluaran', 'Target Penjualan'],
                        datasets: [
                            {
                                label: 'Total (Rp)',
                                data: [
                                    userData.transaksi_pengeluaran.total,
                                    userData.target_penjualan.total
                                ],
                                backgroundColor: [
                                    'rgba(0, 51, 202, 0.72)',
                                    'rgba(202, 59, 0, 0.72)'
                                ],
                            },
                            {
                                label: 'Jumlah Transaksi',
                                data: [
                                    userData.transaksi_pengeluaran.count,
                                    userData.target_penjualan.count
                                ],
                                backgroundColor: [
                                    'rgba(0, 153, 102, 0.72)',
                                    'rgba(255, 153, 0, 0.72)'
                                ],
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
                                    text: 'Jenis Data',
                                },
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Total (Rp) / Jumlah',
                                },
                                beginAtZero: true,
                            },
                        },
                    },
                });
            });
        }
    });
</script>
@endsection

@section('scripts')
@endsection
