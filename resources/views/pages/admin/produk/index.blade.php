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
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
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
                                data-bs-target="#addProdukModal">
                                <i class="ph ph-plus fs-5"></i>
                                Tambah Produk
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
                                            <th class="crancy-table__column-3 crancy-table__h2">Harga Beli</th>
                                            <th class="crancy-table__column-3 crancy-table__h2">Harga Jual</th>
                                            <th class="crancy-table__column-3 crancy-table__h2">Stok</th>
                                            <th class="crancy-table__column-5 crancy-table__h5 text-center"
                                                style="width: 1%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="crancy-table__body">
                                        @if ($produks->count() > 0)
                                            @foreach ($produks as $item)
                                                <tr>
                                                    <td class="crancy-table__column-1 fw-semibold">{{ $loop->iteration }}
                                                    </td>
                                                    <td class="crancy-table__column-2 fw-semibold">{{ $item->nama ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-2 fw-semibold">
                                                        {{ $item->kode_produk ?? '-' }}</td>
                                                    <td class="crancy-table__column-2 fw-semibold">
                                                        {{ $item->kategori->nama ?? '-' }}</td>
                                                    <td class="crancy-table__column-3 fw-semibold">
                                                        {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                                    <td class="crancy-table__column-3 fw-semibold">
                                                        {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                    <td class="crancy-table__column-3 fw-semibold">{{ $item->stok }}</td>
                                                    <td class="crancy-table__column-5 text-center">
                                                        <div class="d-flex align-items-center gap-2 justify-content-center">
                                                            <button type="button"
                                                                class="btn-view btn-cst btn-primary d-flex align-items-center justify-content-center w-auto px-2"
                                                                data-id="{{ $item->id }}"
                                                                data-nama="{{ $item->nama }}"
                                                                data-kode_produk="{{ $item->kode_produk }}"
                                                                data-satuan="{{ $item->satuan }}"
                                                                data-harga_beli="{{ $item->harga_beli }}"
                                                                data-harga_jual="{{ $item->harga_jual }}"
                                                                data-deskripsi="{{ $item->deskripsi }}"
                                                                data-foto="{{ $item->foto }}"
                                                                data-stok="{{ $item->stok }}"
                                                                data-kategori="{{ $item->kategori->nama }}"
                                                                data-bs-toggle="modal" data-bs-target="#viewProdukModal">
                                                                Detail
                                                            </button>
                                                            <button type="button"
                                                                class="btn-edit btn-cst btn-warning d-flex align-items-center justify-content-center w-auto px-2"
                                                                data-id="{{ $item->id }}"
                                                                data-nama="{{ $item->nama }}"
                                                                data-nama="{{ $item->nama }}"
                                                                data-kode_produk="{{ $item->kode_produk }}"
                                                                data-satuan="{{ $item->satuan }}"
                                                                data-harga_beli="{{ $item->harga_beli }}"
                                                                data-harga_jual="{{ $item->harga_jual }}"
                                                                data-stok="{{ $item->stok }}"
                                                                data-deskripsi="{{ $item->deskripsi }}"
                                                                data-kategori_id="{{ $item->kategori_id }}"
                                                                data-foto="{{ $item->foto }}" data-bs-toggle="modal"
                                                                data-bs-target="#editProdukModal">
                                                                Edit
                                                            </button>
                                                            <form
                                                                action="{{ route('manajemen-produk.destroy', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn-cst btn-danger d-flex align-items-center justify-content-center w-auto px-2">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
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

    <!-- Modal Lihat Produk -->
    <div id="viewProdukModal" class="modal fade" tabindex="-1" aria-labelledby="viewProdukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="viewProdukModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk:</label>
                        <p id="viewNamaProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        {{-- <label class="form-label fw-bold">Foto Produk:</label> --}}

                        <img id="viewFotoProduk" src="" alt="Foto Produk" width="200"
                            class="border rounded-3" />

                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Produk:</label>
                        <p id="viewKodeProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Satuan:</label>
                        <p id="viewSatuanProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga Beli:</label>
                        <p id="viewHargaBeliProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga Jual:</label>
                        <p id="viewHargaJualProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <p id="viewDeskripsiProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Stok:</label>
                        <p id="viewStokProduk" class="fw-semibold"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori:</label>
                        <p id="viewKategoriProduk" class="fw-semibold"></p>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



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
                        <input id="foto" class="crancy-wc__form-input form-file fw-semibold" type="file"
                            name="foto" />
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

    <!-- Modal Edit Produk -->
    <div id="editProdukModal" class="modal fade" tabindex="-1" aria-labelledby="editProdukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form method="POST" action="" class="modal-content" id="editProdukForm"
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
                            name="nama" placeholder="Masukan nama produk" required />
                    </div>


                    <div class="mb-5 form-group">
                        <label class="form-label" for="editSatuan">Satuan <span class="text-danger">*</span></label>
                        <select id="editSatuan" class="form-select crancy__item-input fw-semibold" name="satuan"
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
                        <label class="form-label" for="editHargaBeli">Harga Beli <span
                                class="text-danger">*</span></label>
                        <input id="editHargaBeli" class="crancy-wc__form-input fw-semibold" type="number"
                            name="harga_beli" value="editHargaBeli" required />
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="editHargaJual">Harga Jual <span
                                class="text-danger">*</span></label>
                        <input id="editHargaJual" class="crancy-wc__form-input fw-semibold" type="number"
                            name="harga_jual" required />
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="editDeskripsi">Deskripsi</label>
                        <textarea id="editDeskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi"></textarea>
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="editFoto">Foto Produk</label>
                        <label for="editFoto" class="btn btn-light rounded-3 py-3 w-100 fw-semibold">
                            Pilih File
                        </label>
                        <input id="editFoto" class="form-control" type="file" name="foto"
                            style="display: none;" />
                        <img id="fotoPreview" src="" alt="Preview Foto" width="100" />
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="editStok">Stok <span class="text-danger">*</span></label>
                        <input id="editStok" class="crancy-wc__form-input fw-semibold" type="number" name="stok"
                            required />
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="editKategoriId">Pilih Kategori <span
                                class="text-danger">*</span></label>
                        <select id="editKategoriId" class="form-select crancy__item-input fw-semibold" name="kategori_id"
                            required>
                            @foreach ($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
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
        $(document).ready(function() {

            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let kode_produk = $(this).data('kode_produk');
                let satuan = $(this).data('satuan');
                let harga_beli = $(this).data('harga_beli');
                let harga_jual = $(this).data('harga_jual');
                let stok = $(this).data('stok');
                let deskripsi = $(this).data('deskripsi');
                let kategori_id = $(this).data('kategori_id');
                let foto = $(this).data('foto');

                $('#editNamaProduk').val(nama);
                $('#editKodeProduk').val(kode_produk);
                $('#editSatuan').val(satuan);
                $('#editHargaBeli').val(harga_beli);
                $('#editHargaJual').val(harga_jual);
                $('#editStok').val(stok);
                $('#editDeskripsi').val(deskripsi);
                $('#editKategoriId').val(kategori_id);

                if (foto) {
                    $('#fotoPreview').attr('src', foto);
                } else {
                    $('#fotoPreview').attr('src', '');
                }

                $('#editProdukForm').attr('action', '/produk/' + id);
            });

            $('#editFoto').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#fotoPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });


        $(document).ready(function() {

            $(document).on('click', '.btn-view', function() {
                let nama = $(this).data('nama');
                let kode_produk = $(this).data('kode_produk');
                let satuan = $(this).data('satuan');
                let harga_beli = $(this).data('harga_beli');
                let harga_jual = $(this).data('harga_jual');
                let deskripsi = $(this).data('deskripsi');
                let stok = $(this).data('stok');
                let kategori = $(this).data('kategori');
                let foto = $(this).data('foto');

                $('#viewNamaProduk').text(nama);
                $('#viewKodeProduk').text(kode_produk);
                $('#viewSatuanProduk').text(satuan);
                $('#viewHargaBeliProduk').text(harga_beli);
                $('#viewHargaJualProduk').text(harga_jual);
                $('#viewDeskripsiProduk').text(deskripsi || '-');
                $('#viewStokProduk').text(stok);
                $('#viewKategoriProduk').text(kategori);

                if (foto) {

                    $('#viewFotoProduk').attr('src', foto);

                } else {
                    $('#viewFotoProduk').hide();
                }
            });
        });
    </script>
@endsection

@section('scripts')
    @include('layouts.datatables-scripts')
@endsection
