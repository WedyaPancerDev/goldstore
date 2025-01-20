@extends('layouts.master')
@section('title')
    Toko Emas - Cabang
@endsection

@section('title-section')
    Cabang
@endsection

@section('css')
    @include('layouts.datatatables-css')
@endsection

@section('content')
    @role('admin|manajer')
        <section class="container container__bscreen mt-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @role('admin')
                                    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                                @endrole

                                @role('manajer')
                                    <li class="breadcrumb-item"><a href="{{ route('manajer.root') }}">Dashboard</a></li>
                                @endrole
                                <li class="breadcrumb-item active">Cabang</li>
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
                                    data-bs-target="#addCabangModal">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Cabang
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
                                                <th class="crancy-table__column-2 crancy-table__h2">Nama Cabang</th>
                                                <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                    style="width: 1%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @if ($cabang->count() > 0)
                                                @foreach ($cabang as $data)
                                                    <tr>
                                                        <td class="crancy-table__column-1 fw-semibold">{{ $loop->iteration }}
                                                        </td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $data->nama_cabang ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-5 text-center">
                                                            @if ($data->is_deleted == 0)
                                                                <div
                                                                    class="d-flex align-items-center gap-2 justify-content-center">
                                                                    <!-- Tombol Edit -->
                                                                    <button type="button"
                                                                        class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editCabangModal-{{ $data->id }}">
                                                                        Edit
                                                                    </button>

                                                                    <!-- Tombol Hapus -->
                                                                    <button type="button"
                                                                        class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeCabangModal-{{ $data->id }}">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <!-- Tombol Aktifkan -->
                                                                <form
                                                                    action="{{ route('manajemen-cabang.restore', $data->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn-cst btn-success d-flex align-items-center justify-content-center w-auto px-2">
                                                                        Aktifkan
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeCabangModal-{{ $data->id }}" class="modal fade zoomIn"
                                                        tabindex="-1" aria-hidden="true">
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
                                                                        Apakah kamu yakin ingin menghapus cabang ini?
                                                                        <strong>Cabang yang dihapus tidak dapat
                                                                            dikembalikan.</strong>
                                                                    </p>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button" class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('manajemen-cabang.destroy', $data->id) }}"
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


        <!-- Modal Tambah Cabang -->
        <div id="addCabangModal" class="modal fade" tabindex="-1" aria-labelledby="addCabangModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('manajemen-cabang.store') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="addCabangModalLabel">Tambah Cabang Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3 form-group">
                            <label class="form-label" for="nama_cabang">Nama Cabang <span
                                    class="text-danger">*</span></label>
                            <input id="nama_cabang" class="crancy-wc__form-input fw-semibold" type="text"
                                name="nama_cabang" placeholder="Masukan nama Cabang" required />
                            @if ($errors->has('nama_cabang'))
                                <div class="pt-2">
                                    <span class="form-text fw-semibold text-danger">{{ $errors->first('nama_cabang') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Tambah cabang</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Cabang -->
        @foreach ($cabang as $data)
            <div id="editCabangModal-{{ $data->id }}" class="modal fade" tabindex="-1"
                aria-labelledby="editCabangModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form method="POST" action="{{ route('manajemen-cabang.update', $data->id) }}" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fs-6" id="editCabangModalLabel">Edit Cabang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="editNama">Nama Cabang <span
                                        class="text-danger">*</span></label>
                                <input id="editNamaCabang" class="crancy-wc__form-input fw-semibold" type="text"
                                    name="nama_cabang" value="{{ $data->nama_cabang }}" required />
                                @if ($errors->has('nama_cabang'))
                                    <div class="pt-2">
                                        <span
                                            class="form-text fw-semibold text-danger">{{ $errors->first('nama_cabang') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button id="btn-submit" type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endrole
@endsection

@section('script')
    @include('layouts.datatables-scripts')
@endsection
