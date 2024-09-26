@extends('layouts.master')
@section('title')
    Toko Emas - Transaksi Pengeluaran
@endsection

@section('title-section')
    Transaksi Pengeluaran
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
                                data-bs-target="#management-transaksi-pengeluaran-create">
                                <i class="ph ph-plus fs-5"></i>
                                Tambah Transaksi Pengeluaran
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
                                                Produk
                                            </th>
                                            <th class="crancy-table__column-4 crancy-table__h4">
                                                Jumlah
                                            </th>
                                            <th class="crancy-table__column-5 crancy-table__h4">
                                                Total
                                            </th>
                                            <th class="crancy-table__column-6 crancy-table__h5">
                                                Deskripsi
                                            </th>
                                            <th class="crancy-table__column-7 crancy-table__h5">
                                                Tanggal Order
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
                                                        {{ $transaksi->nama_produk ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-4 fw-semibold">
                                                        {{ $transaksi->quantity ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-5 fw-semibold">
                                                        {{ $transaksi->total_price ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-6 fw-semibold">
                                                        {{ $transaksi->deskripsi ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-7 fw-semibold">
                                                        {{ $transaksi->order_date ?? '-' }}
                                                    </td>
                                                    <td class="crancy-table__column-8">
                                                        <button type="button" class="btn-edit btn-cst btn-warning px-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#management-transaksi-pengeluaran-edit-{{ $transaksi->id }}">
                                                            Ubah
                                                        </button>
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

    {{-- create --}}
    <div id="management-transaksi-pengeluaran-create" class="modal fade" tabindex="-1"
        aria-labelledby="management-transaksi-pengeluaran" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable">
            <form method="POST" action="{{ route('manajemen-transaksi-pengeluaran.store') }}" class="modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="management-transaksi-pengeluaran">Tambah Transaksi Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">

                    <div class="mb-5 form-group">
                        <label class="form-label" for="product_id">Pilih Produk <span class="text-danger">*</span></label>
                        <select id="product_id" class="form-select crancy__item-input" name="product_id" required>
                            <option data-display="Tentukan Produk" selected disabled></option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->harga_jual }}">
                                    {{ $product->nama }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_id'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('product_id') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
                        <input id="quantity" class="form-control" type="text" name="quantity"
                            placeholder="Masukkan Quantity" value="0" required />

                        @if ($errors->has('quantity'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('quantity') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="total_price">Total Harga <span
                                class="text-danger">*</span></label>
                        <input id="total_price" class="form-control" type="text" name="total_price" value="0"
                            readonly />
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi"></textarea>
                        @if ($errors->has('deskripsi'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('deskripsi') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="order_date">Tanggal Order <span
                                class="text-danger">*</span></label>
                        <input id="order_date" class="form-control" type="date" name="order_date" required />
                        @if ($errors->has('order_date'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('order_date') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Transaksi</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    @foreach ($transaksiPengeluaran as $transaksi)
        <div id="management-transaksi-pengeluaran-edit-{{ $transaksi->id }}" class="modal fade" tabindex="-1"
            aria-labelledby="management-transaksi-pengeluaran" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('manajemen-transaksi-pengeluaran.update', $transaksi->id) }}"
                    class="modal-content" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="management-transaksi-pengeluaran">Edit Transaksi Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">

                        <div class="mb-5 form-group">
                            <label class="form-label" for="product_id">Pilih Produk <span
                                    class="text-danger">*</span></label>
                            <select id="product_id" class="form-select crancy__item-input fw-semibold" name="product_id"
                                required>
                                <option data-display="Tentukan Produk" selected disabled></option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->harga_jual }}"
                                        {{ $transaksi->produk_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))
                                <div class="pt-2">
                                    <span class="form-text text-danger">{{ $errors->first('product_id') }}</span>
                                </div>
                            @endif
                        </div>


                        <div class="mb-3 form-group">
                            <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input id="quantity" class="form-control" type="text" name="quantity"
                                placeholder="Masukkan Quantity" value="{{ $transaksi->quantity }}" required />

                            @if ($errors->has('quantity'))
                                <div class="pt-2">
                                    <span class="form-text text-danger">{{ $errors->first('quantity') }}</span>
                                </div>
                            @endif
                        </div>


                        <div class="mb-3 form-group">
                            <label class="form-label" for="total_price">Total Harga <span
                                    class="text-danger">*</span></label>
                            <input id="total_price" class="form-control" type="text" name="total_price"
                                value="{{ $transaksi->total_price }}" value="0" readonly />
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label" for="deskripsi">Deskripsi <span
                                    class="text-danger">*</span></label>
                            <textarea id="deskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi">{{ $transaksi->deskripsi }}</textarea>
                            @if ($errors->has('deskripsi'))
                                <div class="pt-2">
                                    <span class="form-text text-danger">{{ $errors->first('deskripsi') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label" for="order_date">Tanggal Order <span
                                    class="text-danger">*</span></label>
                            <input id="order_date" class="form-control" type="date" name="order_date"
                                value="{{ $transaksi->order_date }}" required />
                            @if ($errors->has('order_date'))
                                <div class="pt-2">
                                    <span class="form-text text-danger">{{ $errors->first('order_date') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Update Transaksi</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection

@section('script')
    @include('layouts.datatables-scripts')

    <script>
        $(document).ready(function() {
            $('#product_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var price = selectedOption.data('price');
                var quantity = $('#quantity').val();

                // Check if quantity is a valid number
                if (quantity && price && !isNaN(quantity)) {
                    $('#total_price').val(price * quantity);
                } else {
                    $('#total_price').val(0); // Set default to 0 if quantity is invalid
                }
            });

            $('#quantity').on('input', function() {
                var quantity = $(this).val();
                var price = $('#product_id').find(':selected').data('price') || 0;

                this.value = this.value.replace(/[^0-9]/g, '');

                if (quantity === "" || isNaN(quantity)) {
                    $('#total_price').val(0);
                } else {
                    var totalPrice = parseInt(quantity) * parseFloat(price);
                    $('#total_price').val(totalPrice);
                }

                var selectedProduct = $('#product_id').val();
                var products = @json($products);
                var product = products.find(p => p.id == selectedProduct);

                if (product) {
                    var stock = product.stok;
                    if (quantity > stock) {
                        $('#stock-warning').text('Stok barang sudah habis.').show();
                    } else {
                        $('#stock-warning').text('').hide();
                    }
                }
            });

            $('#total_price').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $(".js-select-2").select2({
                theme: "default",
            });
        });
    </script>
@endsection
