@extends('layouts.master')
@section('title')
Toko Emas - Staff Dashboard
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

    <div class="col-xxl-12 col-12">
        <div class="crancy-body">
            <div class="crancy-dsinner">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel"
                        aria-labelledby="crancy-table-tab-1">
                        <div class="crancy-table crancy-table--v3 mg-top-30 p-5">
                            <div class="w-full">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
   fetch('/getTargetAndTransaksi')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.months,
                datasets: [
                    {
                        label: 'Transaksi Pengeluaran',
                        data: data.transaksi_pengeluaran,
                        backgroundColor: 'rgba(0, 51, 202, 0.72)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Target Penjualan',
                        data: data.target_penjualan,
                        backgroundColor: 'rgba(202, 59, 0, 0.72)',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
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
                            text: 'Total'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error:', error));

</script>


@endsection

@section('scripts')
@endsection