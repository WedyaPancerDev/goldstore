@extends('layouts.master')
@section('title')
Toko Emas - Master Bonus
@endsection

@section('title-section')
    Pengguna
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
                        <li class="breadcrumb-item active">Master Bonus</li>
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
                            data-bs-target="#addBonusModal">
                            <i class="ph ph-plus fs-5"></i>
                            Tambah Bonus
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
                                                placeholder="Cari bonus berdasarkan nama atau lainnya ..." />
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Crancy Table --}}
                            <table id="table-container" class="crancy-table__main crancy-table__main-v3">
                                {{-- crancy Table Head --}}
                                <thead class="crancy-table__head">
                                    <tr>
                                        <th class="crancy-table__column-1 crancy-table__h2">
                                            No
                                        </th>
                                        <th class="crancy-table__column-2 crancy-table__h2">
                                            Nama Bonus
                                        </th>
                                        <th class="crancy-table__column-3 crancy-table__h3">
                                            Jumlah (Amount)
                                        </th>
                                        <th class="crancy-table__column-4 crancy-table__h4">
                                            Tanggal Dibuat
                                        </th>
                                        <th class="crancy-table__column-5 crancy-table__h5">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                
                                {{-- crancy Table Body --}}
                                <tbody class="crancy-table__body">
                                    @if ($bonuses->count() > 0)
                                    @foreach ($bonuses as $bonus)
                                    <tr>
                                        <td class="crancy-table__column-1 fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="crancy-table__column-2 fw-semibold">
                                            {{ $bonus->nama ?? '-' }}
                                        </td>
                                        <td class="crancy-table__column-3 fw-semibold">
                                            Rp {{ number_format($bonus->total, 0, ',', '.') }}
                                        </td>
                                        <td class="crancy-table__column-4 fw-semibold">
                                            {{ \Carbon\Carbon::parse($bonus->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="crancy-table__column-5 fw-semibold">
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" data-bonus-id="{{ $bonus->id }}"
                                                    class="btn-edit btn-cst btn-warning px-2">
                                                    Edit
                                                </button>
                                
                                                {{-- <form action="{{ route('manajemen-master-bonus.destroy', $bonus->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-cst btn-danger d-flex align-items-center justify-content-center px-2">
                                                        Hapus
                                                    </button>
                                                </form>--}}
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data bonus yang ditemukan.</td>
                                    </tr>
                                    @endif
                                </tbody>
                                
                                {{-- End crancy Table Body --}}
                            </table>
                            {{-- End crancy Table --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Bonus -->
<div class="modal fade" id="addBonusModal" tabindex="-1" aria-labelledby="addBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBonusModalLabel">Tambah Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manajemen-master-bonus.store') }}" method="POST" class="p-2">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Bonus</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="total" class="form-label">Total (Amount)</label>
                    <input type="number" class="form-control" id="total" name="total" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
{{-- <script>
    $(document).ready(function(){
        $(document).on('click', '.btn-edit', function() {
            let userId = $(this).data('user-id');
            window.location.href = 'pengguna/' + userId + '/edit';
        });
    });
</script> --}}
@endsection

@section('scripts')
    @include('layouts.datatables-scripts')
@endsection