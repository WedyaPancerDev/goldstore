@extends('layouts.master')
@section('title')
    Toko Emas - Profile
@endsection

@section('content')

<section class="container container__bscreen mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Profile</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-12 col-12">
        <div class="crancy-body">
            <div class="crancy-dsinner">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="crancy-table-tab-1" role="tabpanel"
                        aria-labelledby="crancy-table-tab-1">
                        <div class="crancy-table crancy-table--v3 mg-top-30 p-5">
                            <div class="w-full">
                                
                                @if ($user)
                                    <div class="d-flex flex-column align-items-center justify-content-center text-center">
                                        <div class="mb-3 ">
                                            <img 
                                            src="{{ $user->profile_picture ? asset($user->profile_picture) : URL::asset('assets/img/user-10.jpg') }}" 
                                            alt="Profile Picture" 
                                            class="rounded-circle"
                                            style="width: 200px; height: 200px; object-fit: cover;" />
                                        </div>
                                        <div>
                                            <p class="fw-bold mb-1">{{ $user->username }}</p>
                                        </div>
                                        <div>
                                            <p class="text-muted">{{ $user->fullname }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex flex-column align-items-center justify-content-center text-center mt-2">
                                    <button id="btn-ubah-profile" class="btn btn-light w-25" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Ubah Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalLabel">Ubah Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="update-profile-form" method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 form-group">
                            <label class="form-label" for="profile_picture">Foto Profile</label>
                            <label for="profile_picture" class="btn btn-light rounded-3 py-3 w-100 fw-semibold">
                                Pilih File
                            </label>
                            <input id="profile_picture" class="form-control" type="file" name="profile_picture" style="display: none;" />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" value="{{ old('username', $user->username ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Masukkan nama lengkap" value="{{ old('fullname', $user->fullname ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password baru">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                                    
                </div>
            </div>
        </div>
    </div>
</section>


@endsection