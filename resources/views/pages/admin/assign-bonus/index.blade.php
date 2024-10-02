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

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-xxl-12 col-12">
        <div class="crancy-body">
            <div class="crancy-dsinner">
                <div class="crancy-table-meta mg-top-30">
                    <div class="crancy-flex-wrap crancy-flex-gap-10 crancy-flex-start">
                        <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                            data-bs-target="#addAssignBonusModal">
                            <i class="ph ph-plus fs-5"></i>
                            Tambah Assign Bonus
                        </button>
                    </div>
                </div>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel"
                        aria-labelledby="crancy-table-tab-1">
                        <div class="crancy-table crancy-table--v3 mg-top-30">
                            <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                <thead class="crancy-table__head">
                                    <tr>
                                        <th class="crancy-table__column-1 crancy-table__h2">No</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">User</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">Transaksi</th>
                                        <th class="crancy-table__column-2 crancy-table__h2">Bonus</th>
                                        <th class="crancy-table__column-5 crancy-table__h5 text-center" style="width: 1%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="crancy-table__body">
                                    @if ($assignBonuses->count() > 0)
                                        @foreach ($assignBonuses as $item)
                                        <tr>
                                            <td class="crancy-table__column-1 fw-semibold">{{ $loop->iteration }}</td>
                                            <td class="crancy-table__column-2 fw-semibold">{{ $item->user->fullname ?? '-' }}</td>
                                            <td class="crancy-table__column-2 fw-semibold">{{ $item->transaksiPengeluaran->nomor_order ?? '-' }}</td>
                                            <td class="crancy-table__column-2 fw-semibold">{{ $item->bonus->nama ?? '-' }}</td>
                                            <td class="crancy-table__column-5 text-center">
                                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                                    <button type="button" class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2"
                                                        data-id="{{ $item->id }}" data-user_id="{{ $item->user_id }}" data-transaksi_id="{{ $item->transaksi_pengeluaran_id }}"
                                                        data-bonus_id="{{ $item->bonus_id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editAssignBonusModal">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('manajemen-assign-bonus.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus assign bonus ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data assign bonus yang ditemukan.</td>
                                        </tr>
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

<!-- Modal Tambah Assign Bonus -->
<div id="addAssignBonusModal" class="modal fade" tabindex="-1" aria-labelledby="addAssignBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="POST" action="{{ route('manajemen-assign-bonus.store') }}" class="modal-content ">
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
<div id="editAssignBonusModal" class="modal fade" tabindex="-1" aria-labelledby="editAssignBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mb-5">
        <form method="POST" action="" class="modal-content" id="editAssignBonusForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fs-6" id="editAssignBonusModalLabel">Edit Assign Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-5 p-5 form-group">
                    <label class="form-label" for="editUserId">User <span class="text-danger">*</span></label>
                    <select id="editUserId" class="form-select crancy__item-input fw-semibold" name="user_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5 form-group">
                    <label class="form-label" for="editTransaksiId">Transaksi <span class="text-danger">*</span></label>
                    <select id="editTransaksiId" class="form-select crancy__item-input fw-semibold" name="transaksi_pengeluaran_id" required>
                        @foreach ($transaksis as $transaksi)
                            <option value="{{ $transaksi->id }}">{{ $transaksi->nomor_order }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-group">
                    <label class="form-label" for="editBonusId">Bonus <span class="text-danger">*</span></label>
                    <select id="editBonusId" class="form-select crancy__item-input fw-semibold" name="bonus_id" required>
                        @foreach ($bonuses as $bonus)
                            <option value="{{ $bonus->id }}">{{ $bonus->nama }}</option>
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

@endsection

@section('script')
<script>
   $(document).ready(function(){

    $(document).on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let user_id = $(this).data('user_id');
        let transaksi_id = $(this).data('transaksi_id');
        let bonus_id = $(this).data('bonus_id');

        $('#editUserId').val(user_id);
        $('#editTransaksiId').val(transaksi_id);
        $('#editBonusId').val(bonus_id);

        $('#editAssignBonusForm').attr('action', '/assign-bonus/' + id);
    });
});
</script>
@endsection

@section('scripts')
    @include('layouts.datatables-scripts')
@endsection