@extends('layouts.master')
@section('title')
    Toko Emas - Transaksi Pengeluaran
@endsection

@section('content')

    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transaksi Pengeluaran</li>
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
                                data-bs-target="#management-user-create">
                                <i class="ph ph-plus fs-5"></i>
                                Tambah Pengguna
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
                                    {{-- crancy Table Head --}}
                                    <thead class="crancy-table__head">
                                        <tr>
                                            <th class="crancy-table__column-1 crancy-table__h2">
                                                No
                                            </th>
                                            <th class="crancy-table__column-2 crancy-table__h2">
                                                Nomor Order
                                            </th>
                                            <th class="crancy-table__column-3 crancy-table__h2">
                                                Tanggal Order
                                            </th>
                                            <th class="crancy-table__column-4 crancy-table__h4">
                                                Produk
                                            </th>
                                            <th class="crancy-table__column-5 crancy-table__h4">
                                                Jumlah
                                            </th>
                                            <th class="crancy-table__column-6 crancy-table__h5">
                                                Total
                                            </th>
                                            <th class="crancy-table__column-7 crancy-table__h5">
                                                Deskripsi
                                            </th>
                                            <th class="crancy-table__column-8 crancy-table__h5">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    {{-- crancy Table Body --}}
                                    <tbody class="crancy-table__body">
                                        @if ($transaksiPengeluaran->count() > 0)
                                            @foreach ($transaksiPengeluaran as $transaksi)
                                                <tr>
                                                    <td class="crancy-table__column-1 fw-semibold">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="crancy-table__column-2 fw-semibold">
                                                        {{ $transaksi->nomor_order ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-3 fw-semibold">
                                                        {{ $transaksi->order_date ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-4 fw-semibold">
                                                        {{ $transaksi->nama_produk ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-5 fw-semibold">
                                                        {{ $transaksi->quantity ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-6 fw-semibold">
                                                        {{ $transaksi->total_price ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-7 fw-semibold">
                                                        {{ $transaksi->deskripsi ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-8">

                                                    </td>
                                                </tr>
                                            @endforeach
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

@endsection

@section('scripts')
    @include('layouts.datatables-scripts')
@endsection
