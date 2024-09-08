@extends('layouts.master')
@section('title')
Toko Emas - Pengguna
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
                        <li class="breadcrumb-item active">Pengguna</li>
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
                            data-bs-target="#management-produk-create">
                            <i class="ph ph-plus fs-5"></i>
                            Tambah produk
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
                                            Nama Lengkap
                                        </th>
                                        <th class="crancy-table__column-3 crancy-table__h3">
                                            Username
                                        </th>
                                        <th class="crancy-table__column-4 crancy-table__h4">
                                            Role
                                        </th>
                                        <th class="crancy-table__column-5 crancy-table__h4">
                                            Status Akun
                                        </th>
                                        <th class="crancy-table__column-6 crancy-table__h5">
                                            Tanggal Masuk
                                        </th>
                                        <th class="crancy-table__column-7 crancy-table__h5">
                                            Terakhir Login
                                        </th>
                                        <th class="crancy-table__column-8 crancy-table__h5">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                {{-- crancy Table Body --}}
                                <tbody class="crancy-table__body">
                                    @if ($users->count() > 0)
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="crancy-table__column-1 fw-semibold">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="crancy-table__column-2 fw-semibold">
                                            {{ $user->fullname ?? '-' }}

                                        </td>
                                        <td class="crancy-table__column-3 fw-semibold">
                                            {{ $user->username ?? '-' }}

                                        </td>
                                        <td class="crancy-table__column-4 fw-semibold">
                                            <div
                                            class="crancy-table__status crancy-table__status--unpaid fw-semibold text-capitalize">
                                            {{ $user->role }}
                                        </div>

                                        </td>
                                        <td class="crancy-table__column-5 fw-semibold">
                                            @if ($user->account_status == 'active')
                                            <div
                                                class="crancy-table__status crancy-table__status--paid fw-semibold text-capitalize">
                                                {{ $user->account_status }}
                                            </div>
                                            @else
                                            <div
                                                class="crancy-table__status crancy-table__status--cancel fw-semibold text-capitalize">
                                                {{ $user->account_status }}
                                            </div>
                                            @endif

                                        </td>
                                        <td class="crancy-table__column-6 fw-semibold">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="crancy-table__column-7 fw-semibold">
                                           
                                            {{ \Carbon\Carbon::parse($user->last_login)->format('d M Y H:i') ?? '-' }}

                                        </td>
                                        <td class="crancy-table__column-8 fw-semibold">
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" data-user-id="{{ $user->id }}"
                                                    class="btn-edit btn-cst btn-warning px-2">
                                                    Edit
                                                </button>

                                                <form action=""
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn-cst btn-danger d-flex align-items-center justify-content-center px-2">
                                                        Nonaktifkan
                                                    </button>
                                                </form>
                                            </div>
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

@section('script')
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-edit', function() {
            let userId = $(this).data('user-id');
            window.location.href = 'pengguna/' + userId + '/edit';
        });
    });
</script>
@endsection

@section('scripts')
    @include('layouts.datatables-scripts')
@endsection
