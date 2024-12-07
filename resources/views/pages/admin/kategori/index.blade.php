@extends('layouts.master')
@section('title')
    Toko Emas - Kategori
@endsection

@section('title-section')
    Kategori
@endsection

@section('css')
    @include('layouts.datatatables-css')
@endsection

@section('content')
    @role('admin|akuntan|manajer|staff')
        <section class="container container__bscreen mt-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kategori</li>
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
                                @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                    <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                        data-bs-target="#addKategoriModal">
                                        <i class="ph ph-plus fs-5"></i>
                                        Tambah Kategori
                                    </button>
                                @endif
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
                                                <th class="crancy-table__column-2 crancy-table__h2">Nama Kategori</th>
                                                @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                    <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                        style="width: 1%;">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @if ($kategori->count() > 0)
                                                @php
                                                    $iteration = 1;
                                                @endphp
                                                @foreach ($kategori as $data)
                                                    <tr>
                                                        <td class="crancy-table__column-1 fw-semibold">{{ $iteration }}</td>
                                                        <td class="crancy-table__column-2 fw-semibold">{{ $data->nama ?? '-' }}
                                                        </td>
                                                        @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                            <td class="crancy-table__column-5 text-center">
                                                                @if ($data->is_deleted == 0)
                                                                    <div
                                                                        class="d-flex align-items-center gap-2 justify-content-center">
                                                                        <!-- Tombol Edit -->
                                                                        <button type="button"
                                                                            class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editKategoriModal-{{ $data->id }}">
                                                                            Edit
                                                                        </button>

                                                                        <!-- Tombol Hapus -->
                                                                        <button type="button"
                                                                            class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#removeKategoriModal-{{ $data->id }}">
                                                                            Hapus
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <!-- Tombol Aktifkan -->
                                                                    <form
                                                                        action="{{ route('manajemen-kategori.restore', $data->id) }}"
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
                                                        @endif
                                                    </tr>

                                                    @php
                                                        $iteration++;
                                                    @endphp

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeKategoriModal-{{ $data->id }}" class="modal fade zoomIn"
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
                                                                        Apakah kamu yakin ingin menghapus kategori ini?
                                                                        <strong>Kategori yang dihapus tidak dapat
                                                                            dikembalikan.</strong>
                                                                    </p>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button" class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('manajemen-kategori.destroy', $data->id) }}"
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


        <!-- Modal Tambah Kategori -->
        <div id="addKategoriModal" class="modal fade" tabindex="-1" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('manajemen-kategori.store') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="addKategoriModalLabel">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3 form-group">
                            <label class="form-label" for="nama">Nama Kategori <span class="text-danger">*</span></label>
                            <input id="nama" class="crancy-wc__form-input fw-semibold" type="text" name="nama"
                                placeholder="Masukan nama kategori" required />
                            @if ($errors->has('nama'))
                                <div class="pt-2">
                                    <span class="form-text fw-semibold text-danger">{{ $errors->first('nama') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Kategori</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Kategori -->
        @foreach ($kategori as $data)
            <div id="editKategoriModal-{{ $data->id }}" class="modal fade" tabindex="-1"
                aria-labelledby="editKategoriModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form method="POST" action="{{ route('manajemen-kategori.update', $data->id) }}" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fs-6" id="editKategoriModalLabel">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="editNama">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <input id="editNamaKategori" class="crancy-wc__form-input fw-semibold" type="text"
                                    name="nama" value="{{ $data->nama }}" required />
                                @if ($errors->has('nama'))
                                    <div class="pt-2">
                                        <span class="form-text fw-semibold text-danger">{{ $errors->first('nama') }}</span>
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
