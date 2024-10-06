@extends('layouts.master')

@section('title')
    Toko Emas - Target Penjualan
@endsection

@section('content')
    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Detail Target Penjualan : {{ $user->fullname ?? '' }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Target Penjualan</li>
                            <li class="breadcrumb-item active">Detail Target Penjualan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-12">
            <div class="crancy-body">
                <div class="crancy-dsinner">
                    <div class="card p-3 mt-4">
                        <div class="row align-items-center">
                            <!-- Select and search button -->
                            <div class="col-lg-8 d-flex align-items-center gap-3">
                                <select name="search_month" id="search_month" class="form-select fw-semibold w-100">
                                    <option value="none" selected hidden>Pilih Bulan</option>
                                    @foreach ($months as $index => $month)
                                        <option value="{{ $index + 1 }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <button id="show-filtered-product" type="button" class="btn btn-success fw-bold w-100"
                                    disabled>
                                    Tampilkan
                                </button>
                            </div>

                            <!-- Reset button -->
                            <div class="col-lg-2">
                                <button id="btn-reset-item" type="button" class="btn btn-secondary fw-bold w-100">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel"
                            aria-labelledby="crancy-table-tab-1">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <div class="crancy-customer-filter crancy-customer-filter--inline">
                                    <div class="crancy-customer-filter__single crancy-customer-filter__search">
                                        <div class="crancy-header__form crancy-header__form--customer">
                                            <form class="crancy-header__form-inner" action="#">
                                                <i class="ph ph-magnifying-glass fs-4 me-2"></i>
                                                <input id="customSearchBox" name="s" type="text"
                                                    placeholder="Cari produk berdasarkan nama, kode, atau lainnya ..." />
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Crancy Table --}}
                                <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                    {{-- Crancy Table Head --}}
                                    <thead class="crancy-table__head">
                                        <tr>
                                            <th class="crancy-table__column-2 crancy-table__h2">Total</th>
                                            <th class="crancy-table__column-3 crancy-table__h5">Status</th>
                                        </tr>
                                    </thead>
                                    {{-- Crancy Table Body --}}
                                    <tbody class="crancy-table__body">
                                        {{-- Data will be populated here --}}
                                    </tbody>
                                    {{-- End Crancy Table Body --}}
                                </table>
                                {{-- End Crancy Table --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#search_month').change(function() {
                if ($(this).val() !== "none") {
                    $('#show-filtered-product').prop('disabled', false);
                } else {
                    $('#show-filtered-product').prop('disabled', true);
                }
            });

            $('#show-filtered-product').click(function() {
                var selectedMonth = $('#search_month').val();
                var userId = "{{ $user->id }}";

                $.ajax({
                    url: "{{ route('manajemen-target-penjualan.detail', ['id' => $user->id]) }}",
                    type: "GET",
                    data: {
                        month: selectedMonth
                    },
                    success: function(response) {
                        var statusClass;

                        if (response.status === 'TERPENUHI') {
                            statusClass = `
                <div class="crancy-table__status crancy-table__status--paid fw-semibold text-capitalize">
                    ${response.status}
                </div>`;
                        } else if (response.status === 'TIDAK TERPENUHI') {
                            statusClass = `
                <div class="crancy-table__status crancy-table__status--cancel fw-semibold text-capitalize">
                    ${response.status}
                </div>`;
                        } else {
                            statusClass = `
                <div class="crancy-table__status fw-semibold text-capitalize">
                    ${response.status}
                </div>`;
                        }

                        if (response.total !== null) {
                            var formattedTotal = parseInt(response.total).toLocaleString(
                                'id-ID');

                            $('tbody').html(`
                <tr>
                    <td class='crancy-table__column-1 fw-semibold'>${formattedTotal}</td>
                    <td class='crancy-table__column-2 fw-semibold'>${statusClass}</td>
                </tr>
            `);
                        } else {
                            $('tbody').html(`
                <tr>
                    <td colspan="2" class="text-center">Data tidak ditemukan</td>
                </tr>
            `);
                        }
                    },
                    error: function() {
                        $('tbody').html(`
            <tr>
                <td colspan="2" class="text-center">Terjadi kesalahan. Silakan coba lagi.</td>
            </tr>
        `);
                    }
                });
            });



            $('#btn-reset-item').click(function() {
                $('#search_month').val('none');
                $('#show-filtered-product').prop('disabled', true);
                $('tbody').html('');
            });
        });
    </script>
@endsection
