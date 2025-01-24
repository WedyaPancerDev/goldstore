@extends('layouts.master')
@section('title')
    Toko Emas - Pengguna
@endsection

@section('title-section')
    Pengguna
@endsection

@section('css')
@endsection

@section('content')

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

                            @role('akuntan')
                                <li class="breadcrumb-item"><a href="{{ route('akuntan.root') }}">Dashboard</a></li>
                            @endrole

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
                            @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                    data-bs-target="#management-user-create">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Pengguna
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
                                            @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                <th class="crancy-table__column-8 crancy-table__h5">
                                                    Aksi
                                                </th>
                                            @endif
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
                                                        @if ($user->last_login == null)
                                                            -
                                                        @else
                                                            {{ \Carbon\Carbon::parse($user->last_login)->format('d M Y H:i') ?? '-' }}
                                                        @endif
                                                    </td>
                                                    @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                        <td class="crancy-table__column-8">
                                                            <div class="d-flex justify-content-center gap-2">
                                                                @if ($user->is_deleted == 0)
                                                                    {{-- EDIT --}}
                                                                    <button type="button"
                                                                        class="btn-edit btn-cst btn-warning px-2 d-flex justify-content-center align-items-center gap-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editUserModal-{{ $user->id }}">
                                                                        <i class="ph ph-pencil"></i>
                                                                        Ubah
                                                                    </button>


                                                                    {{-- DELETE / DEACTIVATE --}}
                                                                    <button type="button"
                                                                        class="btn-cst btn-danger d-flex align-items-center justify-content-center px-2 gap-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeNotificationModal-{{ $loop->iteration }}">
                                                                        <i class="ph ph-trash"></i>
                                                                        Non Aktifkan
                                                                    </button>

                                                                    <!-- Modal for Deactivation Confirmation -->
                                                                    <div id="removeNotificationModal-{{ $loop->iteration }}"
                                                                        class="modal fade zoomIn" tabindex="-1"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <!-- Modal Header -->
                                                                                <div class="modal-header border-0">
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>

                                                                                <!-- Modal Body -->
                                                                                <div class="modal-body text-center p-4">
                                                                                    <div class="text-danger mb-4">
                                                                                        <i
                                                                                            class="bi bi-trash display-4"></i>
                                                                                    </div>
                                                                                    <h4 class="mb-2">Apakah kamu yakin?
                                                                                    </h4>
                                                                                    <p class="text-muted mb-4">
                                                                                        Apakah kamu yakin ingin
                                                                                        menonaktifkan
                                                                                        pengguna ini?
                                                                                        <strong>Pengguna yang dinonaktifkan
                                                                                            bisa
                                                                                            diaktifkan lagi.</strong>
                                                                                    </p>

                                                                                    <!-- Action Buttons -->
                                                                                    <div
                                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                                        <button type="button"
                                                                                            class="btn btn-light btn-sm"
                                                                                            data-bs-dismiss="modal">
                                                                                            Batal
                                                                                        </button>
                                                                                        <form
                                                                                            action="{{ route('admin.manajemen-pengguna.destroy', $user->id) }}"
                                                                                            method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit"
                                                                                                class="btn btn-danger btn-sm">
                                                                                                Iya, Nonaktifkan!
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    {{-- ACTIVATE --}}
                                                                    <form
                                                                        action="{{ route('admin.manajemen-pengguna.restore', $user->id) }}"
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
                                                    @endif
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

    {{-- create --}}
    <div id="management-user-create" class="modal fade" tabindex="-1" aria-labelledby="management-user"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable">
            <form method="POST" action="{{ route('manajemen-pengguna.store') }}" class="modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="management-user">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="fullname">Nama Lengkap <span class="text-danger">*</span></label>
                        <input id="fullname" class="crancy-wc__form-input fw-semibold" type="text" name="fullname"
                            placeholder="Masukan nama lengkap" required />
                        @if ($errors->has('fullname'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">
                                    {{ $errors->first('fullname') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="username">Username <span class="text-danger">*</span></label>
                        <input id="username" class="crancy-wc__form-input fw-semibold" type="text" name="username"
                            placeholder="Masukan Username" required />
                        @if ($errors->has('username'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">
                                    {{ $errors->first('username') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                        <input id="password" class="crancy-wc__form-input fw-semibold" type="password" name="password"
                            placeholder="Masukan password" required />

                        @if ($errors->has('password'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="role">Pilih Role <span class="text-danger">*</span></label>
                        <select id="role" class="form-select crancy__item-input fw-semibold" name="role">
                            <option data-display="Tentukan Role" selected disabled></option>
                            <option value="manajer">Manajer</option>
                            <option value="akuntan">Akuntan</option>
                            <option value="staff">Staff</option>
                        </select>
                        @if ($errors->has('role'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">
                                    {{ $errors->first('role') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Pengguna</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- edt --}}
    @foreach ($users as $user)
        <div id="editUserModal-{{ $user->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('manajemen-pengguna.update', $user->id) }}" class="modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <!-- Full Name -->
                        <div class="mb-3 form-group">
                            <label class="form-label" for="fullname-{{ $user->id }}">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <input id="fullname-{{ $user->id }}" class="crancy-wc__form-input fw-semibold"
                                type="text" name="fullname" value="{{ $user->fullname }}" required />
                            @if ($errors->has('fullname'))
                                <div class="pt-2">
                                    <span
                                        class="form-text fw-semibold text-danger">{{ $errors->first('fullname') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Username -->
                        <div class="mb-3 form-group">
                            <label class="form-label" for="username-{{ $user->id }}">Username <span
                                    class="text-danger">*</span></label>
                            <input id="username-{{ $user->id }}" class="crancy-wc__form-input fw-semibold"
                                type="text" name="username" value="{{ $user->username }}" required />
                            @if ($errors->has('username'))
                                <div class="pt-2">
                                    <span
                                        class="form-text fw-semibold text-danger">{{ $errors->first('username') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Role -->
                        @if ($user->role != 'admin')
                            <div class="mb-3 form-group">
                                <label class="form-label" for="role-{{ $user->id }}">Role <span
                                        class="text-danger">*</span></label>
                                <select id="role-{{ $user->id }}" class="form-select crancy__item-input fw-semibold"
                                    name="role">
                                    <option value="manajer" {{ $user->role == 'manajer' ? 'selected' : '' }}>Manajer
                                    </option>
                                    <option value="akuntan" {{ $user->role == 'akuntan' ? 'selected' : '' }}>Akuntan
                                    </option>
                                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @if ($errors->has('role'))
                                    <div class="pt-2">
                                        <span
                                            class="form-text fw-semibold text-danger">{{ $errors->first('role') }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach



@endsection


@section('scripts')
    @include('layouts.datatables-scripts')
@endsection
