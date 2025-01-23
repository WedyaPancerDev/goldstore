@extends('layouts.master')
@section('title')
    Toko Emas - Harga Gaji
@endsection

@section('title-section')
    Harga Gaji
@endsection

@section('content')
    @role('akuntan|manajer')
        <section class="container container__bscreen mt-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Detail Harga Gaji : {{ $user->username ? $user->fullname : 'N/A' }}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @role('akuntan')
                                    <li class="breadcrumb-item"><a href="{{ route('akuntan.root') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('harga-gaji.index') }}">Biaya
                                            Gaji</a></li>
                                @endrole

                                @role('manajer')
                                    <li class="breadcrumb-item"><a href="{{ route('manajer.root') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('harga-gaji.index') }}">Biaya
                                            Gaji</a></li>
                                @endrole
                                <li class="breadcrumb-item active">Harga Gaji</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-12">
                <div class="crancy-body">
                    <div class="crancy-dsinner">
                        <!-- Filter Section -->
                        <div class="card p-3 mt-4">
                            <div class="row align-items-center">
                                <div class="col-lg-4 d-flex align-items-center gap-3">
                                    <select name="search_month" id="search_month" class="form-select fw-semibold">
                                        <option value="none" selected hidden>Pilih Bulan</option>
                                        @foreach ($months as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4 d-flex align-items-center gap-3">
                                    <select name="search_year" id="search_year" class="form-select fw-semibold">
                                        <option value="none" selected hidden>Pilih Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <button id="btn-reset-filter" type="button"
                                        class="btn btn-secondary fw-bold w-100 d-flex justify-content-center align-items-md-center gap-2">
                                        <i class="ph ph-arrow-clockwise fs-5"></i>
                                        Reset
                                    </button>
                                </div>

                                <div class="col-lg-2">
                                    <button type="button"
                                        class="btn btn-success fw-bold w-100 d-flex justify-content-center align-items-center gap-2"
                                        data-bs-toggle="modal" data-bs-target="#addHargaGajiModal">
                                        <i class="ph ph-plus fs-5"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel">
                                <div class="crancy-table crancy-table--v3 mg-top-30">
                                    <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-2 crancy-table__h2">Harga</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">Bulan</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">Tahun</th>
                                                <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                    style="width: 20%;">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            <tr>
                                                <td colspan="2" class="text-center">Silakan pilih filter untuk melihat data.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('pages.akuntan.biaya-gaji.harga-gaji.modal-harga-gaji')
        </section>
    @endrole
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function updateTable() {
                const selectedMonth = $('#search_month').val();
                const selectedYear = $('#search_year').val();

                if (selectedMonth === 'none' && selectedYear === 'none') {
                    return;
                }

                $.ajax({
                    url: "{{ route('harga-gaji.filter', $user->id) }}",
                    type: "GET",
                    data: {
                        month: selectedMonth,
                        year: selectedYear
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            let tableContent = '';
                            response.data.forEach(function(item) {
                                const formattedHarga = parseInt(item.harga).toLocaleString(
                                    'id-ID');
                                const formattedMonth = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November',
                                    'Desember'
                                ][item.bulan - 1];
                                const formattedYear = item.tahun;

                                tableContent += `
                                    <tr>
                                        <td class="crancy-table__column-2 fw-semibold">Rp ${formattedHarga}</td>
                                        <td class="crancy-table__column-2 fw-semibold">${formattedMonth}</td>
                                        <td class="crancy-table__column-2 fw-semibold">${formattedYear}</td>
                                        <td class="crancy-table__column-5 text-center">
                                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                                <button type="button" class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2 gap-2"
                                                    data-bs-toggle="modal" data-bs-target="#editHargaGajiModal-${item.id}">
                                                    <i class="ph ph-pencil fs-5"></i>
                                                    Edit
                                                </button>
                                                <button type="button" class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2 gap-2"
                                                    data-bs-toggle="modal" data-bs-target="#removeHargaGajiModal-${item.id}">
                                                    <i class="ph ph-trash fs-5"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('.crancy-table__body').html(tableContent);
                        } else {
                            $('.crancy-table__body').html(`
                                <tr>
                                    <td colspan="2" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            `);
                        }
                    },
                    error: function() {
                        $('.crancy-table__body').html(`
                            <tr>
                                <td colspan="2" class="text-center">Terjadi kesalahan. Silakan coba lagi.</td>
                            </tr>
                        `);
                    }
                });
            }

            $('#search_month, #search_year').change(function() {
                updateTable();
            });

            $('#btn-reset-filter').click(function() {
                $('#search_month, #search_year').val('none');
                $('.crancy-table__body').html(`
                    <tr>
                        <td colspan="2" class="text-center">Silakan pilih filter untuk melihat data.</td>
                    </tr>
                `);
            });
        });
    </script>
@endsection
