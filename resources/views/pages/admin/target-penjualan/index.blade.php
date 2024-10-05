@extends('layouts.master')
@section('title')
    Toko Emas - Target Penjualan
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
                        <div class="crancy-flex-wrap crancy-flex-gap-10 crancy-flex-start">
                            <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                data-bs-target="#addTargetPenjualan">
                                <i class="ph ph-plus fs-5"></i>
                                Tambah Target Penjualan
                            </button>
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
                                            <th class="crancy-table__column-1 crancy-table__h2">No</th>
                                            <th class="crancy-table__column-2 crancy-table__h2">Pengguna</th>
                                            <th class="crancy-table__column-3 crancy-table__h5">Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- Crancy Table Body --}}
                                    <tbody class="crancy-table__body">
                                        @if ($targetPenjualan->count() > 0)
                                            @foreach ($targetPenjualan as $target)
                                                <tr>
                                                    <td class="crancy-table__column-1 fw-semibold">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="crancy-table__column-2 fw-semibold">
                                                        {{ $target->fullname ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-3">
                                                        <div class="d-flex justify-content-evenly gap-2">
                                                            @if ($target->is_deleted == 0)
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


                                                                <button type="button" class="btn-cst btn-danger px-3"
                                                                    data-bs-toggle="modal" style="width: 20%"
                                                                    data-bs-target="#removeTargetModal-{{ $target->user_id }}">
                                                                    Nonaktifkan
                                                                </button>

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
                                                            @else
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

    <!-- create -->
    <div id="addTargetPenjualan" class="modal fade" tabindex="-1" aria-labelledby="addTargetPenjualan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" style="height: 75vh; max-height: 90vh;">
            <form method="POST" action="{{ route('manajemen-target-penjualan.store') }}" class="modal-content"
                style="height: 100%;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="addTargetPenjualan">Tambah Target Penjualan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 mb-4" style="overflow-y: auto;">
                    <div class="mb-5 form-group">
                        <label class="form-label">Pengguna <span class="text-danger">*</span></label>
                        <select class="form-select crancy__item-input fw-semibold" name="user_id" required>
                            <option value="" disabled selected>Pilih Pengguna</option>
                            @foreach ($usersBelumTerdaftar as $user)
                                <option value="{{ $user->id }}">{{ $user->fullname }} ({{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Target Penjualan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
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

            $(".js-select-2").select2({
                theme: "default",
            });
        });
    </script>
@endsection
