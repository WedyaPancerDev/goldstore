@extends('layouts.master')
@section('title')
    Toko Emas - Biaya Operasional
@endsection

@section('title-section')
    Biaya Operasional
@endsection

@section('css')
    @include('layouts.datatatables-css')
@endsection

@section('content')
    @role('akuntan|manajer')
        <section class="container container__bscreen mt-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @role('akuntan')
                                    <li class="breadcrumb-item"><a href="{{ route('akuntan.root') }}">Dashboard</a></li>
                                @endrole

                                @role('manajer')
                                    <li class="breadcrumb-item"><a href="{{ route('manajer.root') }}">Dashboard</a></li>
                                @endrole
                                <li class="breadcrumb-item active">Biaya Operasional</li>
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
                                    data-bs-target="#addBiayaOperasionalModal">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Biaya Operasional
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
                                                        placeholder="Cari produk berdasarkan nama atau lainnya ..." />
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Crancy Table --}}
                                    <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                        <thead class="crancy-table__head">
                                            <tr>
                                                <th class="crancy-table__column-1 crancy-table__h2">No</th>
                                                <th class="crancy-table__column-2 crancy-table__h2">Nama Biaya Operasional</th>
                                                <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                    style="width: 1%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @if ($biaya_operasional->count() > 0)
                                                @foreach ($biaya_operasional as $data)
                                                    <tr>
                                                        <td class="crancy-table__column-1 fw-semibold">{{ $loop->iteration }}
                                                        </td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $data->nama_biaya_operasional ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-5 text-center">
                                                            @if ($data->is_deleted == 0)
                                                                <div
                                                                    class="d-flex align-items-center gap-2 justify-content-center">
                                                                    <!-- Tombol Detail -->
                                                                    <a
                                                                        class="btn-detail rounded-lg btn-cst btn-primary d-flex align-items-center justify-content-center w-auto px-2 d-flex justify-content-lg-center gap-2">
                                                                        <i class="ph ph-eye fs-5"></i>
                                                                        Details
                                                                    </a>
                                                                    <!-- Tombol Edit -->
                                                                    <button type="button"
                                                                        class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2 d-flex justify-content-lg-center gap-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editBiayaOperasionalModal-{{ $data->id }}">
                                                                        <i class="ph ph-pencil fs-5"></i>
                                                                        Edit
                                                                    </button>

                                                                    <!-- Tombol Hapus -->
                                                                    <button type="button"
                                                                        class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2 gap-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeBiayaOperasionalModal-{{ $data->id }}">
                                                                        <i class="ph ph-trash fs-5"></i>
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <!-- Tombol Aktifkan -->
                                                                <form
                                                                    action="{{ route('biaya-operasional.restore', $data->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn-cst btn-success d-flex align-items-center justify-content-center w-auto px-2 gap-2">
                                                                        <i class="ph ph-check fs-5"></i>
                                                                        Aktifkan
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeBiayaOperasionalModal-{{ $data->id }}"
                                                        class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-0">
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center p-4">
                                                                    <div class="text-danger mb-4">
                                                                        <i class="bi bi-trash display-4"></i>
                                                                    </div>
                                                                    <h4 class="mb-2">Apakah kamu yakin?</h4>
                                                                    <p class="text-muted mb-4">
                                                                        Apakah kamu yakin ingin menghapus biaya operasional ini?
                                                                        <strong>Biaya Operasional yang dihapus tidak dapat
                                                                            dikembalikan.</strong>
                                                                    </p>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button" class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('biaya-operasional.destroy', $data->id) }}"
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
                                                @endforeach
                                            @endif

                                        </tbody>

                                    </table>

                                    {{-- End crancy Table --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- create modal --}}
        @include('pages.akuntan.biaya-operasional.create')
        {{-- end create modal --}}

        {{-- edit modal --}}
        @include('pages.akuntan.biaya-operasional.edit')
        {{-- end edit modal --}}
    @endrole
@endsection

@section('script')
    @include('layouts.datatables-scripts')
@endsection
