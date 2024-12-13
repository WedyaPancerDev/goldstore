@extends('layouts.master')
@section('title')
    Toko Emas - Target Penjualan
@endsection

@section('title-section')
    Target Penjualan
@endsection

@section('content')
    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Target Penjualan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-12">
            <div class="crancy-body">
                <div class="crancy-dsinner">
                    <div class="crancy-table-meta mg-top-30">
                        @role('admin|akuntan|manajer')
                            <div class="crancy-flex-wrap crancy-flex-gap-10 crancy-flex-between">
                                <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                    data-bs-target="#addTargetPenjualan">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Target Penjualan
                                </button>
                                <div class="d-flex gap-2 ">
                                    <div data-bs-toggle="modal" data-bs-target="#laporanPDF"
                                        class="btn btn-danger font-bold p-2 d-flex align-items-center gap-2">
                                        <i class="ph ph-note fs-5"></i>
                                        Laporan PDF
                                    </div>

                                    <div data-bs-toggle="modal" data-bs-target="#laporanEXEL"
                                        class="btn btn-warning font-bold p-2 text-white d-flex align-items-center gap-2">
                                        <i class="ph ph-note fs-5"></i>
                                        laporan exel
                                    </div>
                                </div>
                            </div>
                        @endrole
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel"
                            aria-labelledby="crancy-table-tab-1">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                    <thead class="crancy-table__head">
                                        <tr>
                                            <th class="crancy-table__column-1 crancy-table__h2">No</th>
                                            <th class="crancy-table__column-2 crancy-table__h2">Pengguna</th>
                                            <th class="crancy-table__column-3 crancy-table__h5">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody class="crancy-table__body">
                                        @if ($targetPenjualan->count() > 0)
                                            @foreach ($targetPenjualan as $target)
                                                <tr>
                                                    <td class="crancy-table__column-1 fw-semibold">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="crancy-table__column-2 fw-semibold">
                                                        {{ $target->username ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-3">
                                                        <div class="d-flex justify-content-evenly gap-1">
                                                            @if ($target->is_deleted == 0)
                                                                {{-- Aksi untuk admin, akuntan, atau manajer --}}
                                                                @role('admin|akuntan|manajer')
                                                                    <a
                                                                        href="{{ route('manajemen-target-penjualan.detail', $target->user_id) }}">
                                                                        <button
                                                                            class="btn-edit btn-cst btn-secondary px-3 text-white fw-semibold">
                                                                            Detail
                                                                        </button>
                                                                    </a>
                                                                    <a
                                                                        href="{{ route('manajemen-target-penjualan.edit', $target->user_id) }}">
                                                                        <button
                                                                            class="btn-edit btn-cst btn-warning px-3 text-white fw-semibold">
                                                                            Ubah
                                                                        </button>
                                                                    </a>
                                                                    <button type="button" class="btn-cst btn-danger px-3 w-25"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeTargetModal-{{ $target->user_id }}">
                                                                        Nonaktifkan
                                                                    </button>
                                                                    <!-- Modal for Deactivation -->
                                                                    <div id="removeTargetModal-{{ $target->user_id }}"
                                                                        class="modal fade zoomIn" tabindex="-1"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header border-0">
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body text-center p-4">
                                                                                    <div class="text-danger mb-4">
                                                                                        <i class="bi bi-trash display-4"></i>
                                                                                    </div>
                                                                                    <h4 class="mb-2">Apakah kamu yakin?</h4>
                                                                                    <p class="text-muted mb-4">
                                                                                        Apakah kamu yakin ingin menonaktifkan
                                                                                        pengguna ini?
                                                                                        <strong>Pengguna yang dinonaktifkan bisa
                                                                                            diaktifkan lagi.</strong>
                                                                                    </p>
                                                                                    <div
                                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                                        <button type="button"
                                                                                            class="btn btn-light btn-sm"
                                                                                            data-bs-dismiss="modal">Batal</button>
                                                                                        <form
                                                                                            action="{{ route('manajemen-target-penjualan.destroy', $target->user_id) }}"
                                                                                            method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit"
                                                                                                class="btn btn-danger btn-sm">Iya,
                                                                                                Nonaktifkan!</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endrole

                                                                {{-- Aksi untuk staff --}}
                                                                @role('staff')
                                                                    <div class="d-flex gap-2 fw-semibold">
                                                                        <a href="{{ route('export.yearly.pdf.byuser', $target->user_id) }}"
                                                                            class="btn btn-warning">
                                                                            Laporan Tahunan PDF
                                                                        </a>
                                                                        <a href="{{ route('export.monthly.pdf.byuser', $target->user_id) }}"
                                                                            class="btn btn-warning">
                                                                            Laporan Bulanan PDF
                                                                        </a>
                                                                        <a href="{{ route('export.yearly.excel.byuser', $target->user_id) }}"
                                                                            class="btn btn-success">
                                                                            Laporan Tahunan Excel
                                                                        </a>
                                                                        <a href="{{ route('export.monthly.excel.byuser', $target->user_id) }}"
                                                                            class="btn btn-success">
                                                                            Laporan Bulanan Excel
                                                                        </a>
                                                                    </div>
                                                                @endrole
                                                            @else
                                                                {{-- Tombol Aktifkan untuk semua pengguna --}}
                                                                <form
                                                                    action="{{ route('manajemen-target-penjualan.restore', $target->user_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn-cst btn-success d-flex align-items-center justify-content-center px-2">
                                                                        Aktifkan
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk Menambah Target Penjualan -->
    <div id="addTargetPenjualan" class="modal fade" tabindex="-1" aria-labelledby="addTargetPenjualan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="height: 75vh; max-height: 90vh;">
            <form method="POST" action="{{ route('manajemen-target-penjualan.store') }}" class="modal-content"
                style="height: 100%;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah Target Penjualan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Pilih Pengguna <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select">
                            <option value="">Pilih Pengguna</option>
                            @foreach ($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                                <!-- Menampilkan username -->
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah Target Penjualan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal pdf --}}
    <div id="laporanPDF" class="modal fade" tabindex="-1" aria-labelledby="laporanPDF" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable d-flex align-items-center justify-content-center"
            style="height: 75vh; max-height: 90vh;">
            <form class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fs-6">Laporan Penjualan PDF</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <a href="{{ route('exportYearlyTargetPenjualan') }}"
                            class="btn btn-danger form-control">Tahunan</a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('exportMonthlyPDF') }}" class="btn btn-danger form-control">Bulanan</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- modal exel --}}
    <div id="laporanEXEL" class="modal fade" tabindex="-1" aria-labelledby="laporanEXEL" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable d-flex align-items-center justify-content-center"
            style="height: 75vh; max-height: 90vh;">
            <form class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fs-6">Laporan Penjualan Exel</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <a href="{{ route('export.yearly.excel') }}"
                            class="btn btn-warning form-control font-bold text-white">Tahunan</a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('export.monthly.excel') }}"
                            class="btn btn-warning form-control font-bold text-white">Bulanan</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    @include('layouts.datatables-scripts')

    <script>
        $(document).ready(function() {
            $('#id_card').on('input', function() {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
            });

            $('#total').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@endsection
