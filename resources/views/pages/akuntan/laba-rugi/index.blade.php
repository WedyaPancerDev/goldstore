@extends('layouts.master')

@section('title')
    Toko Emas - Laporan Laba Rugi
@endsection

@section('title-section')
    Laporan Laba Rugi
@endsection

@section('css')
    <style>
        @media print {

            /* Sembunyikan semua elemen */
            body * {
                visibility: hidden;
            }

            /* Hanya tampilkan elemen dalam #printable-area */
            #printable-area,
            #printable-area * {
                visibility: visible;
            }

            /* Atur posisi area cetak */
            #printable-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            /* Hilangkan tombol cetak */
            .no-print {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Laporan Laba Rugi</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            @role('manajer')
                                <li class="breadcrumb-item"><a href="{{ route('manajer.root') }}">Dashboard</a></li>
                            @endrole
                            @role('akuntan')
                                <li class="breadcrumb-item"><a href="{{ route('akuntan.root') }}">Dashboard</a></li>
                            @endrole
                            <li class="breadcrumb-item active">Laporan Laba Rugi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card p-3">
            <div class="row align-items-center">
                {{-- <div class="col-lg-4 d-flex align-items-center gap-3">
                    <select name="search_month" id="search_month" class="form-select fw-semibold">
                        <option value="none" selected>Semua Bulan</option>
                        @foreach ($months as $index => $month)
                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- Hidden month filter, default to 'none' (semua bulan) -->
                <input type="hidden" name="search_month" id="search_month" value="none">

                <div class="col-lg-8 d-flex align-items-center gap-3">
                    <select name="search_year" id="search_year" class="form-select fw-semibold">
                        <option value="none" selected>Semua Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <button id="btn-reset-filter" type="button" class="btn btn-secondary fw-bold w-100">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <div id="printable-area">
            <!-- Report Content -->
            <div class="card mt-4">
                <div class="card-header bg-light py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0" id="period-title">Laporan Laba Rugi - Semua Periode</h5>
                        </div>
                        <div class="col-auto no-print">
                            <button class="btn btn-sm btn-success px-3" onclick="printContent()">
                                <i class="bi bi-printer me-1"></i> Cetak Halaman Ini
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Revenue Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Pendapatan</h6>
                        <div class="ps-3">
                            <div class="row border-bottom py-2">
                                <div class="col">Penjualan</div>
                                <div class="col-auto" id="revenue">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Expenses Section -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Pengeluaran</h6>

                        <!-- Operational Costs -->
                        <div class="ps-3 mb-3">
                            <div class="fw-semibold mb-2">Biaya Operasional</div>
                            <div id="operational-costs" class="ps-3">
                                <!-- Filled by JavaScript -->
                            </div>
                            <div class="row border-top pt-2">
                                <div class="col">Total Biaya Operasional</div>
                                <div class="col-auto" id="total-operational">Rp 0</div>
                            </div>
                        </div>

                        <!-- Production Costs -->
                        <div class="ps-3 mb-3">
                            <div class="fw-semibold mb-2">Biaya Produksi</div>
                            <div id="production-costs" class="ps-3">
                                <!-- Filled by JavaScript -->
                            </div>
                            <div class="row border-top pt-2">
                                <div class="col">Total Biaya Produksi</div>
                                <div class="col-auto" id="total-production">Rp 0</div>
                            </div>
                        </div>

                        <!-- Salary and Bonus -->
                        <div class="ps-3">
                            <div class="row py-2">
                                <div class="col">Gaji Karyawan</div>
                                <div class="col-auto" id="total-salary">Rp 0</div>
                            </div>
                            <div class="row py-2">
                                <div class="col">Bonus Karyawan</div>
                                <div class="col-auto" id="total-bonus">Rp 0</div>
                            </div>
                        </div>

                        <!-- Total Expenses -->
                        <div class="row border-top border-2 mt-3 pt-3">
                            <div class="col fw-bold">Total Pengeluaran</div>
                            <div class="col-auto fw-bold" id="total-expenses">Rp 0</div>
                        </div>
                    </div>

                    <!-- Net Profit/Loss -->
                    <div class="row border-top border-2 border-dark mt-4 pt-4">
                        <div class="col">
                            <h5 class="fw-bold mb-0">Laba/Rugi Bersih</h5>
                        </div>
                        <div class="col-auto">
                            <h5 class="fw-bold mb-0" id="net-profit">Rp 0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script>
        function printContent() {
            // Simpan konten asli halaman
            const originalContent = document.body.innerHTML;

            // Ambil konten dari elemen yang ingin dicetak
            const printArea = document.getElementById('printable-area').outerHTML;

            // Ganti isi body dengan konten yang akan dicetak
            document.body.innerHTML = printArea;

            // Cetak halaman
            window.print();

            // Kembalikan konten asli
            document.body.innerHTML = originalContent;

            // Reload untuk mengembalikan event handler
            window.location.reload();
        }


        $(document).ready(function() {
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            }

            function updateReport() {
                const selectedMonth = $('#search_month').val();
                const selectedYear = $('#search_year').val();

                $.ajax({
                    url: "{{ route('laba-rugi.filter') }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;

                            // Update period title
                            $('#period-title').text(
                                `Laporan Laba Rugi - ${data.period.month} ${data.period.year}`);

                            // Update revenue
                            $('#revenue').text(formatCurrency(data.revenue));

                            // Update operational costs
                            let operationalHtml = '';
                            data.expenses.operational.forEach(function(item) {
                                operationalHtml += `
                                    <div class="row py-2">
                                        <div class="col">${item.nama}</div>
                                        <div class="col-auto">${formatCurrency(item.total)}</div>
                                    </div>
                                `;
                            });
                            $('#operational-costs').html(operationalHtml);
                            $('#total-operational').text(formatCurrency(data.totals.operational));

                            // Update production costs
                            let productionHtml = '';
                            data.expenses.production.forEach(function(item) {
                                productionHtml += `
                                    <div class="row py-2">
                                        <div class="col">${item.nama}</div>
                                        <div class="col-auto">${formatCurrency(item.total)}</div>
                                    </div>
                                `;
                            });
                            $('#production-costs').html(productionHtml);
                            $('#total-production').text(formatCurrency(data.totals.production));

                            // Update salary and bonus
                            $('#total-salary').text(formatCurrency(data.expenses.salary));
                            $('#total-bonus').text(formatCurrency(data.expenses.bonus));

                            // Update total expenses
                            $('#total-expenses').text(formatCurrency(data.totals.expenses));

                            // Update net profit/loss
                            const netProfitElement = $('#net-profit');
                            netProfitElement.text(formatCurrency(data.totals.net_profit));

                            // Add color based on profit/loss
                            if (data.totals.net_profit < 0) {
                                netProfitElement.removeClass('text-success').addClass('text-danger');
                            } else {
                                netProfitElement.removeClass('text-danger').addClass('text-success');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data. Silakan coba lagi.');
                    }
                });
            }

            // Event handler untuk filter
            $('#search_month, #search_year').on('change', function() {
                updateReport();
            });

            // Reset filter
            $('#btn-reset-filter').on('click', function() {
                $('#search_month').val('none');
                $('#search_year').val('none');
                updateReport();
            });

            // Load data awal
            updateReport();
        });
    </script>
@endsection
