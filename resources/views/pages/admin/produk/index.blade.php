@extends('layouts.master')
@section('title')
    Toko Emas - Produk
@endsection

@section('title-section')
    Produk
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
                            @role('admin')
                                <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            @endrole

                            @role('manajer')
                                <li class="breadcrumb-item"><a href="{{ route('manajer.root') }}">Dashboard</a></li>
                            @endrole

                            @role('akuntan')
                                <li class="breadcrumb-item"><a href="{{ route('akuntan.root') }}">Dashboard</a></li>
                            @endrole

                            @role('staff')
                                <li class="breadcrumb-item"><a href="{{ route('staff.root') }}">Dashboard</a></li>
                            @endrole

                            <li class="breadcrumb-item active">Produk</li>
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
                                    data-bs-target="#addProdukModal">
                                    <i class="ph ph-plus fs-5"></i>
                                    Tambah Produk
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
                                            <th class="crancy-table__column-2 crancy-table__h2">Nama Produk</th>
                                            <th class="crancy-table__column-2 crancy-table__h2">Kode Produk</th>
                                            <th class="crancy-table__column-2 crancy-table__h2">Kategori</th>
                                            {{-- <th class="crancy-table__column-3 crancy-table__h2">Harga Beli</th> --}}
                                            <th class="crancy-table__column-3 crancy-table__h2">Harga Jual</th>
                                            <th class="crancy-table__column-3 crancy-table__h2">Stok</th>
                                            @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                    style="width: 1%;">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="crancy-table__body">
                                        @if ($produks->count() > 0)
                                            {{-- @php
                                                $iteration = 1;
                                            @endphp --}}
                                            @foreach ($produks as $item)
                                                @if ($item->is_deleted == 0)
                                                    <tr>
                                                        <td class="crancy-table__column-1 fw-semibold">
                                                            {{ $loop->iteration }}</td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $item->nama ?? '-' }}</td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $item->kode_produk ?? '-' }}</td>
                                                        <td class="crancy-table__column-2 fw-semibold">
                                                            {{ $item->kategori->nama ?? '-' }}</td>
                                                        {{-- <td class="crancy-table__column-3 fw-semibold">{{ number_format($item->harga_beli, 0, ',', '.') }}</td> --}}
                                                        <td class="crancy-table__column-3 fw-semibold">
                                                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                        <td class="crancy-table__column-3 fw-semibold">{{ $item->stok }}
                                                        </td>
                                                        @if (empty(array_intersect(['staff', 'akuntan'], $userRole)))
                                                            <td class="crancy-table__column-5 text-center">
                                                                <div
                                                                    class="d-flex align-items-center gap-2 justify-content-center">
                                                                    <button type="button"
                                                                        class="btn-edit btn-cst btn-light d-flex align-items-center gap-2 justify-content-center w-auto px-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#detailProdukModal-{{ $item->id }}">
                                                                        <i class="ph ph-eye fs-5"></i>
                                                                        Detail
                                                                    </button>

                                                                    <button type="button"
                                                                        class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center gap-2 w-auto px-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editProdukModal-{{ $item->id }}">
                                                                        <i class="ph ph-pencil fs-5"></i>
                                                                        Edit
                                                                    </button>

                                                                    <button type="button"
                                                                        class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2 gap-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeProdukModal-{{ $item->id }}">
                                                                        <i class="ph ph-trash fs-5"></i>
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    {{-- @php
                                                    $iteration++;
                                                @endphp --}}

                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeProdukModal-{{ $item->id }}"
                                                        class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
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
                                                                        <strong>Produk yang dihapus tidak dapat
                                                                            dikembalikan.</strong>
                                                                    </p>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button" class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('manajemen-produk.destroy', $item->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm">Iya,
                                                                                Hapus!</button>
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

    <!-- Modal Tambah Produk -->
    <div id="addProdukModal" class="modal fade" tabindex="-1" aria-labelledby="addProdukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form method="POST" action="{{ route('manajemen-produk.store') }}" class="modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="addProdukModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="nama">Nama Produk <span class="text-danger">*</span></label>
                        <input id="nama" class="crancy-wc__form-input fw-semibold" type="text" name="nama"
                            placeholder="Masukan nama produk" required />
                    </div>
                    <div class="mb-5 pb-3 form-group">
                        <label class="form-label" for="satuan">Satuan <span class="text-danger">*</span></label>
                        <select id="satuan" class="form-select crancy__item-input fw-semibold" name="satuan"
                            required>
                            <option value="" disabled selected>Pilih Satuan</option>
                            <option value="pcs">Pieces</option>
                            <option value="kg">Kilogram</option>
                            <option value="gr">Gram</option>
                            <option value="mg">Milligram</option>
                            <option value="ml">Milliliter</option>
                            <option value="l">Liter</option>
                            <option value="m">Meter</option>
                            <option value="cm">Centimeter</option>
                            <option value="mm">Millimeter</option>
                            <option value="inch">Inch</option>
                            <option value="feet">Feet</option>
                            <option value="yard">Yard</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                        <input id="harga_beli" class="crancy-wc__form-input fw-semibold" type="number"
                            name="harga_beli" placeholder="Masukan harga beli" required />
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                        <input id="harga_jual" class="crancy-wc__form-input fw-semibold" type="number"
                            name="harga_jual" placeholder="Masukan harga jual" required />
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi"
                            placeholder="Masukan deskripsi produk"></textarea>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="foto">Foto Produk</label>
                        <label for="foto" class="btn btn-light rounded-3 py-3 w-100 fw-semibold">
                            Pilih File
                        </label>
                        <input id="foto" class="form-control" type="file" name="foto"
                            style="display: none;" />
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="stok">Stok <span class="text-danger">*</span></label>
                        <input id="stok" class="crancy-wc__form-input fw-semibold" type="number" name="stok"
                            placeholder="Masukan stok" required />
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="kategori_id">Pilih Kategori <span
                                class="text-danger">*</span></label>
                        <select id="kategori_id" class="form-select crancy__item-input fw-semibold" name="kategori_id"
                            required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                </div>

                <div class="modal-footer">
                    <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Produk</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Lihat Produk -->
    @foreach ($produks as $item)
        <div id="detailProdukModal-{{ $item->id }}" class="modal fade" tabindex="-1"
            aria-labelledby="detailProdukModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="viewProdukModalLabel">Detail Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Produk:</label>
                            <p id="viewNamaProduk" class="fw-semibold">{{ $item->nama }}</p>
                        </div>

                        <div class="mb-3 d-flex justify-content-center">

                            <img id="viewFotoProduk" src="{{ $item->foto }}" alt="Foto Produk" width="200"
                                class="border rounded-3" />

                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kode Produk:</label>
                            <p id="viewKodeProduk" class="fw-semibold">{{ $item->kode_produk }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Satuan:</label>
                            <p id="viewSatuanProduk" class="fw-semibold">{{ $item->satuan }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Beli:</label>
                            <p id="viewHargaBeliProduk" class="fw-semibold">{{ $item->harga_beli }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Jual:</label>
                            <p id="viewHargaJualProduk" class="fw-semibold">{{ $item->harga_jual }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi:</label>
                            <p id="viewDeskripsiProduk" class="fw-semibold">{{ $item->deskripsi }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Stok:</label>
                            <p id="viewStokProduk" class="fw-semibold">{{ $item->stok }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori:</label>
                            <p id="viewKategoriProduk" class="fw-semibold">
                                {{ $item->kategori->nama ?? 'Kategori tidak tersedia' }}</p>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Edit Produk -->
    @foreach ($produks as $item)
        <div id="editProdukModal-{{ $item->id }}" class="modal fade" tabindex="-1"
            aria-labelledby="editProdukModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('manajemen-produk.update', $item->id) }}" class="modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="editProdukModalLabel">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editNamaProduk">Nama Produk <span
                                    class="text-danger">*</span></label>
                            <input id="editNamaProduk" class="crancy-wc__form-input fw-semibold" type="text"
                                name="nama" value="{{ $item->nama }}" required />
                        </div>
                        <div class="mb-5 form-group">
                            <label class="form-label" for="editSatuan">Satuan <span class="text-danger">*</span></label>
                            <select id="editSatuan" class="form-select crancy__item-input fw-semibold" name="satuan"
                                required>
                                <option value="" disabled>Pilih Satuan</option>
                                <option value="pcs" {{ $item->satuan == 'pcs' ? 'selected' : '' }}>Pieces</option>
                                <option value="kg" {{ $item->satuan == 'kg' ? 'selected' : '' }}>Kilogram</option>
                                <option value="gr" {{ $item->satuan == 'gr' ? 'selected' : '' }}>Gram</option>
                                <option value="mg" {{ $item->satuan == 'mg' ? 'selected' : '' }}>Milligram</option>
                                <option value="ml" {{ $item->satuan == 'ml' ? 'selected' : '' }}>Milliliter</option>
                                <option value="l" {{ $item->satuan == 'l' ? 'selected' : '' }}>Liter</option>
                                <option value="m" {{ $item->satuan == 'm' ? 'selected' : '' }}>Meter</option>
                                <option value="cm" {{ $item->satuan == 'cm' ? 'selected' : '' }}>Centimeter</option>
                                <option value="mm" {{ $item->satuan == 'mm' ? 'selected' : '' }}>Millimeter</option>
                                <option value="inch" {{ $item->satuan == 'inch' ? 'selected' : '' }}>Inch</option>
                                <option value="feet" {{ $item->satuan == 'feet' ? 'selected' : '' }}>Feet</option>
                                <option value="yard" {{ $item->satuan == 'yard' ? 'selected' : '' }}>Yard</option>
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editHargaBeli">Harga Beli <span
                                    class="text-danger">*</span></label>
                            <input id="editHargaBeli" class="crancy-wc__form-input fw-semibold" type="number"
                                name="harga_beli" value="{{ $item->harga_beli }}" required />
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editHargaJual">Harga Jual <span
                                    class="text-danger">*</span></label>
                            <input id="editHargaJual" class="crancy-wc__form-input fw-semibold" type="number"
                                name="harga_jual" value="{{ $item->harga_jual }}" required />
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editDeskripsi">Deskripsi</label>
                            <textarea id="editDeskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi">{{ $item->deskripsi }}</textarea>
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editFoto">Foto Produk</label>
                            <label for="editFoto" class="btn btn-light rounded-3 py-3 w-100 fw-semibold">
                                Pilih File
                            </label>
                            <input id="editFoto" class="form-control" type="file" name="foto"
                                style="display: none;" />
                            <img id="fotoPreview-{{ $item->id }}" src="{{ $item->foto }}" alt="Foto Produk"
                                width="100" />
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label" for="editStok">Stok <span class="text-danger">*</span></label>
                            <input id="editStok" class="crancy-wc__form-input fw-semibold" type="number"
                                name="stok" value="{{ $item->stok }}" required />
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label" for="editKategoriId">Pilih Kategori <span
                                    class="text-danger">*</span></label>
                            <select id="editKategoriId" class="form-select crancy__item-input fw-semibold"
                                name="kategori_id" required>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id }}"
                                        {{ $item->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}
                                    </option>
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
