@extends('layouts.master')
@section('title')
Toko Emas - Assign Bonus
@endsection

@section('title-section')
    Assign Bonus
@endsection

@section('css')
    @include('layouts.datatatables-css')
@endsection

@section('content')
<section class="container container__bscreen mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Assign Bonus</li>
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
                            data-bs-target="#addAssignBonusModal">
                            <i class="ph ph-plus fs-5"></i>
                            Tambah Assign Bonus
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
                                                placeholder="Cari kategori berdasarkan nama atau lainnya ..." />
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                <thead class="crancy-table__head">
                                    <tr>
                                        <th class="crancy-table__column-1 crancy-table__h2">No</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">User</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">Transaksi</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">Bonus</th>
                                        @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                        <th class="crancy-table__column-5 crancy-table__h5 text-center" style="width: 1%;">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="crancy-table__body">
                                    @if ($assignBonuses->count() > 0)
                                        @php
                                            $iteration = 1;
                                        @endphp
                                        @foreach ($assignBonuses as $item)
                                            @if ($item->is_deleted == 0)
                                            <tr>
                                                <td class="crancy-table__column-1 fw-semibold">{{ $iteration }}</td>
                                                <td class="crancy-table__column-2 fw-semibold">{{ $item->users->fullname ?? '-' }}</td>
                                                <td class="crancy-table__column-2 fw-semibold">{{ $item->transaksi_pengeluaran->nomor_order ?? '-' }}</td>
                                                <td class="crancy-table__column-2 fw-semibold">{{ $item->bonus->nama ?? '-' }}</td>
                                                @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                <td class="crancy-table__column-5 text-center">
                                                    <div class="d-flex align-items-center gap-2 justify-content-center">
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editAssignBonusModal-{{ $item->id }}">
                                                            Edit
                                                        </button>

                                                        <!-- Tombol Hapus dengan Modal -->
                                                        <button type="button" class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#removeProdukModal-{{ $item->id }}">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @php
                                                $iteration++;
                                            @endphp


                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeProdukModal-{{ $item->id }}" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
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
                                                                        Apakah kamu yakin ingin menghapus produk ini? 
                                                                        <strong>Produk yang dihapus tidak dapat dikembalikan.</strong>
                                                                    </p>
                                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button" class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form action="{{ route('manajemen-assign-bonus.destroy', $item->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger btn-sm">Iya, Hapus!</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
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

<!-- Modal Tambah Assign Bonus -->
<div id="addAssignBonusModal" class="modal fade" tabindex="-1" aria-labelledby="addAssignBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="POST" action="{{ route('manajemen-assign-bonus.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fs-6" id="addAssignBonusModalLabel">Tambah Assign Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 pb-5 ">
                <div class="mb-5 pb-3 form-group ">
                    <label class="form-label" for="user_id">User <span class="text-danger">*</span></label>
                    <select id="user_id" class="form-select crancy__item-input fw-semibold" name="user_id" required>
                        <option value="" disabled selected>Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5 py-3 form-group">
                    <label class="form-label" for="transaksi_pengeluaran_id">Transaksi <span class="text-danger">*</span></label>
                    <select id="transaksi_pengeluaran_id" class="form-select crancy__item-input fw-semibold" name="transaksi_pengeluaran_id" required>
                        <option value="" disabled selected>Pilih Transaksi</option>
                        @foreach ($transaksis as $transaksi)
                            <option value="{{ $transaksi->id }}">{{ $transaksi->nomor_order }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5 py-3 form-group">
                    <label class="form-label" for="bonus_id">Bonus <span class="text-danger">*</span></label>
                    <select id="bonus_id" class="form-select crancy__item-input fw-semibold" name="bonus_id" required>
                        <option value="" disabled selected>Pilih Bonus</option>
                        @foreach ($bonuses as $bonus)
                            <option value="{{ $bonus->id }}">{{ $bonus->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Bonus</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Assign Bonus -->
@foreach ($assignBonuses as $item)
<div id="editAssignBonusModal-{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="editAssignBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mb-5">
        <form method="POST" action="{{ route('manajemen-assign-bonus.update', $item->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fs-6" id="editAssignBonusModalLabel">Edit Assign Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-5 form-group">
                    <label class="form-label" for="editUserId">User <span class="text-danger">*</span></label>
                    <select id="editUserId" class="form-select crancy__item-input fw-semibold" name="user_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5 form-group">
                    <label class="form-label" for="editTransaksiId">Transaksi <span class="text-danger">*</span></label>
                    <select id="editTransaksiId" class="form-select crancy__item-input fw-semibold" name="transaksi_pengeluaran_id" required>
                        @foreach ($transaksis as $transaksi)
                            <option value="{{ $transaksi->id }}" {{ $item->transaksi_pengeluaran_id == $transaksi->id ? 'selected' : '' }}>{{ $transaksi->nomor_order }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-group">
                    <label class="form-label" for="editBonusId">Bonus <span class="text-danger">*</span></label>
                    <select id="editBonusId" class="form-select crancy__item-input fw-semibold" name="bonus_id" required>
                        @foreach ($bonuses as $bonus)
                            <option value="{{ $bonus->id }}" {{ $item->bonus_id == $bonus->id ? 'selected' : '' }}>{{ $bonus->nama }}</option>
                        @endforeach
                    </select>
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

@endsection

@section('script')
    @include('layouts.datatables-scripts')
@endsection
