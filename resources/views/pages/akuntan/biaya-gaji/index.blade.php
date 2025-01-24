@extends('layouts.master')
@section('title')
    Toko Emas - Biaya Gaji
@endsection

@section('title-section')
    Biaya Gaji
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
                                <li class="breadcrumb-item active">Biaya Gaji</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-12">
                <div class="crancy-body">
                    <div class="crancy-dsinner">
                        {{-- <div class="crancy-table-meta mg-top-30">
                            <div class="crancy-flex-wrap crancy-flex-gap-10 crancy-flex-start">
                                <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                    data-bs-target="#addBiayagajiModal">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Biaya gaji
                                </button>
                            </div>
                        </div> --}}

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
                                                <th class="crancy-table__column-2 crancy-table__h2">Nama Biaya Gaji</th>
                                                <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                    style="width: 1%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="crancy-table__body">
                                            @if ($users->count() > 0)
                                                @foreach ($users as $data)
                                                    <tr>
                                                        <td class="crancy-table__column-1 fw-semibold">{{ $loop->iteration }}
                                                        </td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $data->username ? $data->fullname : '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-5 text-center">
                                                            @if ($data->is_deleted == 0)
                                                                <div
                                                                    class="d-flex align-items-center gap-2 justify-content-center">
                                                                    <!-- Tombol Detail -->
                                                                    <a href="{{ route('harga-gaji.show', $data->id) }}"
                                                                        class="px-3 text-white fw-semibold d-flex align-items-center justify-content-center gap-2">
                                                                        <button
                                                                            class="btn-edit btn-cst btn-secondary px-3 text-white fw-semibold d-flex align-items-center justify-content-center gap-2">
                                                                            <i class="ph ph-eye fs-5"></i>
                                                                            Detail
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
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
    @endrole
@endsection

@section('script')
    @include('layouts.datatables-scripts')
@endsection
