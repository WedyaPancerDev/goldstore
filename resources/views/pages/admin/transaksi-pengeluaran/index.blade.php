@extends('layouts.master')
@section('title')
    Toko Emas - Transaksi Penjualan
@endsection

@section('title-section')
    Transaksi Penjualan
@endsection

@section('css')
    @include('layouts.datatatables-css')
    <style>
        @media print {

            /* Sembunyikan semua elemen */
            body * {
                visibility: hidden;
            }

            /* Hanya tampilkan elemen dalam #printable-area */
            #printable-area,
            #printable-area * {
                visibility: visible;
            }

            /* Atur posisi area cetak */
            #printable-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            /* Hilangkan tombol cetak */
            .no-print {
                display: none !important;
            }

            /* Hilangkan kolom aksi */
            .crancy-table__column-9,
            .crancy-table__column-9 * {
                display: none !important;
            }
        }
    </style>
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
                            <li class="breadcrumb-item active">Transaksi Penjualan</li>
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
                            @role('staff|manajer')
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="button" class="crancy-btn crancy-btn__filter" data-bs-toggle="modal"
                                            data-bs-target="#management-transaksi-pengeluaran-create">
                                            <i class="ph ph-plus fs-5"></i>
                                            Tambah Transaksi Penjualan
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button
                                            class="btn btn-sm btn-success px-3 d-flex justify-content-center align-items-center gap-2"
                                            onclick="printContent()">
                                            <i class="ph ph-printer fs-5"></i>
                                            Cetak Halaman Ini
                                        </button>

                                        {{-- all data tabel via controller --}}
                                        {{-- <a href="{{ route('export.transaksi-pengeluaran.excel') }}">
                                            <button
                                                class="btn btn-sm btn-warning px-4 py-2 d-flex justify-content-center align-items-center gap-2 fw-bold"
                                                style="min-width: 200px;">
                                                <i class="ph ph-printer fs-5"></i>
                                                Cetak Excel
                                            </button>
                                        </a> --}}


                                        {{-- all data via search by ajax --}}
                                        <button
                                            class="btn btn-sm btn-warning px-4 py-2 d-flex justify-content-center align-items-center gap-2 fw-bold"
                                            style="min-width: 200px;" onclick="exportToExcel()">
                                            <i class="ph ph-printer fs-5"></i>
                                            Cetak Excel
                                        </button>

                                    </div>
                                </div>
                            @endrole
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
                                <div id="printable-area">
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
                                                    Nama User
                                                </th>
                                                <th class="crancy-table__column-4 crancy-table__h2">
                                                    Produk
                                                </th>
                                                <th class="crancy-table__column-4 crancy-table__h2">
                                                    Cabang
                                                </th>
                                                <th class="crancy-table__column-5 crancy-table__h4">
                                                    Jumlah
                                                </th>
                                                <th class="crancy-table__column-6 crancy-table__h4">
                                                    Total
                                                </th>
                                                <th class="crancy-table__column-7 crancy-table__h5">
                                                    Deskripsi
                                                </th>
                                                <th class="crancy-table__column-8 crancy-table__h5">
                                                    Tanggal Order
                                                </th>
                                                {{-- @if (empty(array_intersect(['akuntan'], $userRole)))
													@role('admin|akuntan|manajer')
														<th class="crancy-table__column-9 crancy-table__h5">
															Aksi
														</th>
													@endrole
												@endif --}}
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
                                                            {{ $transaksi->nama_user ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-4 fw-semibold">
                                                            {{ $transaksi->nama_produk ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-4 fw-semibold">
                                                            {{ $transaksi->nama_cabang ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-5 fw-semibold">
                                                            {{ $transaksi->quantity ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-6 fw-semibold">
                                                            Rp
                                                            {{ number_format($transaksi->total_price ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td class="crancy-table__column-7 fw-semibold">
                                                            {{ $transaksi->deskripsi ?? '-' }}
                                                        </td>
                                                        <td class="crancy-table__column-8tar fw-semibold">
                                                            {{ $transaksi->order_date ?? '-' }}
                                                        </td>
                                                        {{-- @if (empty(array_intersect(['akuntan'], $userRole)))
															@role('admin|akuntan|manajer')
																<td class="crancy-table__column-8">
																	<button type="button"
																		class="btn-edit btn-cst btn-warning px-2 d-flex align-items-center justify-content-center gap-2"
																		data-bs-toggle="modal" data-bs-target="#management-transaksi-pengeluaran-edit-{{ $transaksi->id }}">
																		<i class="ph ph-pencil"></i>
																		Ubah
																	</button>
																</td>
															@endrole
														@endif --}}
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        {{-- End crancy Table Body --}}
                                    </table>
                                </div>
                                {{-- End crancy Table --}}
                                <div style="text-align: left; margin-left: 50px;">
                                    <p style="font-size: 17px; font-weight: bold;">
                                        Jumlah Total: {{ $transaksiPengeluaran->sum('quantity') }}
                                    </p>
                                    <p style="font-size: 17px; font-weight: bold;">
                                        Total Keseluruhan: Rp
                                        {{ number_format($transaksiPengeluaran->sum('total_price'), 0, ',', '.') }}
                                    </p>
                                </div>
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
                    <!-- Produk -->
                    <div class="mb-5 form-group">
                        <label class="form-label" for="product_id">Pilih Produk <span class="text-danger">*</span></label>
                        <select class="form-select crancy__item-input product-select" name="product_id" required>
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

                    <!-- User -->
                    <div class="mb-5 form-group">
                        <label class="form-label">Pilih User <span class="text-danger">*</span></label>
                        <div id="user-selection-container">
                            <div class="d-flex align-items-center mb-2 user-select-row">
                                <select class="form-select user-select" name="user_ids[]" required>
                                    <option data-display="Pilih User" selected disabled></option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-sm btn-success ms-2 add-user-btn">Tambah</button>
                            </div>
                        </div>
                        <span class="form-text text-muted">Maksimal 3 user dapat dipilih.</span>
                    </div>

                    <!-- Cabang -->
                    <div class="mb-5 form-group">
                        <label class="form-label" for="cabang_id">Pilih Cabang <span class="text-danger">*</span></label>
                        <select class="form-select crancy__item-input cabang-select" name="cabang_id" required>
                            <option data-display="Tentukan Cabang" selected disabled></option>
                            @foreach ($cabang as $cabg)
                                <option value="{{ $cabg->id }}">
                                    {{ $cabg->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('cabang_id'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('cabang_id') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3 pt-3 form-group">
                        <label class="form-label" for="quantity">Quantity <span class="text-danger">*</span></label>
                        <input class="form-control quantity-input" type="text" name="quantity"
                            placeholder="Masukkan Quantity" required />
                        <span id="stock-warning" class="text-danger py-2 text-sm"></span>
                        @if ($errors->has('quantity'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('quantity') }}</span>
                            </div>
                        @endif
                    </div>

                    <span id="stock-warning" class="text-danger py-2 text-sm"></span>


                    <!-- Total Harga -->
                    <div class="mb-3 form-group">
                        <label class="form-label" for="total_price">Total Harga <span
                                class="text-danger">*</span></label>
                        <input id="total_price" class="form-control" type="text" name="total_price" value="0"
                            readonly />
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3 form-group">
                        <label class="form-label" for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi"></textarea>
                        @if ($errors->has('deskripsi'))
                            <div class="pt-2">
                                <span class="form-text text-danger">{{ $errors->first('deskripsi') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Tanggal Order -->
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
                    <button type="submit" id="btn-submit" class="btn btn-primary" disabled>Tambah Transaksi</button>
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
                            <select class="form-select crancy__item-input product-select" name="product_id" required
                                data-original="{{ $transaksi->produk_id }}">
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
                            <input id="quantity" class="form-control quantity-input" type="text" name="quantity"
                                placeholder="Masukkan Quantity" value="{{ $transaksi->quantity }}" required
                                data-original="{{ $transaksi->quantity }}" />

                            <span id="stock-warning" class="text-danger py-2 text-sm"></span>

                        </div>


                        <div class="mb-3 form-group">
                            <label class="form-label" for="total_price">Total Harga <span
                                    class="text-danger">*</span></label>
                            <input id="total_price" class="form-control" type="text" name="total_price"
                                value="  {{ number_format($transaksi->total_price ?? 0, 0, ',', '.') }}" value="0"
                                readonly />
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label" for="deskripsi">Deskripsi <span
                                    class="text-danger">*</span></label>
                            <textarea id="deskripsi" class="crancy-wc__form-input fw-semibold" name="deskripsi"
                                data-original="{{ $transaksi->deskripsi }}">{{ $transaksi->deskripsi }}</textarea>
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
                        <button type="submit" id="btn-submit" class="btn btn-primary" disabled>Update</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection

@section('script')
    @include('layouts.datatables-scripts')

    {{-- script modal create --}}
    <script>
        // print PDF
        function printContent() {
            const originalContent = document.body.innerHTML;

            const printArea = document.getElementById('printable-area').outerHTML;

            document.body.innerHTML = printArea;

            window.print();

            document.body.innerHTML = originalContent;

            window.location.reload();
        }

        // Print exel
        function exportToExcel() {
            const tableData = [];
            const rows = document.querySelectorAll('table tr');

            rows.forEach((row, rowIndex) => {
                const rowData = [];
                row.querySelectorAll('th, td').forEach((cell) => {
                    rowData.push(cell.innerText);
                });
                tableData.push(rowData);
            });

            let csvContent = "data:text/csv;charset=utf-8," + tableData.map(e => e.join(",")).join("\n");

            const dateNow = new Date().toISOString().slice(0, 19).replace('T', '-');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `table_data_transaksi_penjualan-${dateNow}.csv`);
            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        }



        $(document).ready(function() {
            let maxUsers = 3;

            // Fungsi untuk mencegah panggilan berulang (debounce)
            function debounce(func, delay) {
                let timer;
                return function(...args) {
                    const context = this;
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            // Memperbarui daftar pilihan pengguna agar tidak ada duplikasi pilihan
            function updateUserOptions() {
                let selectedUsers = [];
                $('.user-select').each(function() {
                    let val = $(this).val();
                    if (val) selectedUsers.push(val);
                });

                $('.user-select').each(function() {
                    let currentSelect = $(this);
                    currentSelect.find('option').each(function() {
                        if ($(this).val() && selectedUsers.includes($(this).val()) && $(this)
                            .val() !== currentSelect.val()) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            // Memvalidasi tombol submit berdasarkan input
            function updateSubmitButtonState() {
                let isProductSelected = $('.product-select').val() !== null;
                let isQuantityValid = $('.quantity-input').val() > 0;
                let isUserSelected = $('.user-select').filter(function() {
                    return $(this).val() !== null && $(this).val() !== '';
                }).length > 0;
                let isCabangSelected = $('.cabang-select').val() !== null;

                $('#btn-submit').prop('disabled', !(isProductSelected && isQuantityValid && isUserSelected &&
                    isCabangSelected));
            }

            // Memeriksa stok produk dan menghitung total harga
            function checkStock(quantity, productId, price, callback) {
                if (productId) {
                    $.ajax({
                        url: '{{ route('check-stock') }}', // Pastikan route sesuai
                        type: 'GET',
                        data: {
                            product_id: productId
                        },
                        success: function(response) {
                            const stok = response.stok;
                            if (quantity > stok) {
                                $('#stock-warning').text(
                                    `Stok tidak mencukupi. Stok tersedia: ${stok}`);
                                $('#total_price').val(0);
                                $('#btn-submit').prop('disabled', true);
                            } else {
                                $('#stock-warning').text('');
                                callback(price * quantity);
                            }
                        },
                    });
                }
            }

            // Menghitung total harga yang dibagi rata
            function calculateSplitTotal() {
                let quantity = parseInt($('.quantity-input').val()) || 0;
                let productPrice = parseFloat($('.product-select').find(':selected').data('price')) || 0;
                let selectedUserCount = $('.user-select').filter(function() {
                    return $(this).val() && $(this).val() !== '';
                }).length;

                if (quantity > 0 && productPrice > 0 && selectedUserCount > 0) {
                    checkStock(quantity, $('.product-select').val(), productPrice, (totalPrice) => {
                        let splitPrice = Math.ceil(totalPrice / selectedUserCount);
                        $('#total_price').val(splitPrice.toLocaleString('id-ID', {
                            minimumFractionDigits: 0
                        }));
                        updateSubmitButtonState();
                    });
                } else {
                    $('#total_price').val(0);
                }
            }

            // Menambah baris pilihan user
            $('#user-selection-container').on('click', '.add-user-btn', function() {
                if ($('.user-select-row').length < maxUsers) {
                    $('#user-selection-container').append(`
                        <div class="d-flex align-items-center mb-2 user-select-row">
                            <select class="form-select user-select" name="user_ids[]" required>
                                <option data-display="Pilih User" selected disabled></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm btn-danger ms-2 remove-user-btn">Hapus</button>
                        </div>
                    `);
                    updateUserOptions();
                    calculateSplitTotal();
                    updateSubmitButtonState();
                }
            });

            // Menghapus baris pilihan user
            $('#user-selection-container').on('click', '.remove-user-btn', function() {
                $(this).closest('.user-select-row').remove();
                updateUserOptions();
                calculateSplitTotal();
                updateSubmitButtonState();
            });

            // Event listener untuk perubahan produk atau kuantitas
            $('.product-select').on('change', function() {
                calculateSplitTotal();
                updateSubmitButtonState();
            });

            $('.quantity-input').on('input', debounce(function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                calculateSplitTotal();
                updateSubmitButtonState();
            }, 500));

            // Event listener untuk perubahan pilihan user
            $('#user-selection-container').on('change', '.user-select', function() {
                updateUserOptions();
                calculateSplitTotal();
                updateSubmitButtonState();
            });

            // Inisialisasi awal
            updateSubmitButtonState();
            calculateSplitTotal();
        });
    </script>

    {{-- script modal edit --}}
    <script>
        $(document).ready(function() {
            function debounce(func, delay) {
                let timer;
                return function(...args) {
                    const context = this;
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            // Function to check if any changes have been made to the form
            function updateEditButtonState(modal) {
                let isChanged = false;

                modal.find('.form-control, .crancy-wc__form-input').each(function() {
                    const originalValue = $(this).data('original');
                    const currentValue = $(this).val();

                    if (currentValue !== originalValue) {
                        isChanged = true;
                        return false;
                    }
                });

                const quantity = modal.find('.quantity-input').val();
                const productSelected = modal.find('.product-select').val();

                modal.find('#btn-submit').prop('disabled', !isChanged);
            }

            // Validate form and check if changes have been made
            $('.modal').on('input change', function() {
                updateEditButtonState($(this));
            });

            // Handle change in product selection
            $('.product-select').on('change', function() {
                calculateTotalPrice($(this));
            });

            // Handle input changes in quantity
            $('.quantity-input').on('input', debounce(function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
                if ($(this).val() === '' || $(this).val() == 0) {
                    $(this).closest('.modal-body').find('#total_price').val(0);
                } else {
                    calculateTotalPrice($(this));
                }
            }, 500));

            // Calculate total price based on selected quantity and product price
            function calculateTotalPrice(quantityInput) {
                let selectedProduct = quantityInput.closest('.modal-body').find('.product-select').find(
                    ':selected');
                let price = selectedProduct.data('price') || 0;
                let quantity = quantityInput.val();

                if (quantity && price && quantity > 0) {
                    checkStock(quantity, selectedProduct.val(), price, quantityInput);
                } else {
                    quantityInput.closest('.modal-body').find('#total_price').val(0);
                }
            }

            // Check stock availability before calculating the total price
            function checkStock(quantity, productId, price, quantityInput) {
                if (productId) {
                    $.ajax({
                        url: '{{ route('check-stock') }}',
                        type: 'GET',
                        data: {
                            product_id: productId
                        },
                        success: function(response) {
                            const stok = response.stok;
                            let stockWarning = quantityInput.closest('.modal-body').find(
                                '#stock-warning');

                            if (quantity > stok) {
                                stockWarning.text(
                                    'Jumlah quantity melebihi stok produk yang tersedia. Stok: ' +
                                    stok);
                                quantityInput.closest('.modal-body').find('#total_price').val(0);
                                $('#btn-submit').prop('disabled', true);
                            } else {
                                stockWarning.text('');
                                const totalPrice = parseFloat(price) * parseInt(quantity);
                                quantityInput.closest('.modal-body').find('#total_price').val(totalPrice
                                    .toLocaleString('id-ID', {
                                        minimumFractionDigits: 0
                                    }));

                                validateForm(quantityInput);
                            }
                        }
                    });
                }
            }

            // Validate form inputs to enable/disable submit button
            function validateForm(element) {
                let selectedProduct = element.closest('.modal-body').find('.product-select').val();
                let quantity = element.closest('.modal-body').find('.quantity-input').val();

                if (selectedProduct && quantity && quantity > 0) {
                    $('#btn-submit').prop('disabled', false);
                } else {
                    $('#btn-submit').prop('disabled', true);
                }
            }

            // Initialize the form and set up modal
            $('.modal').on('show.bs.modal', function() {
                updateEditButtonState($(this)); // Check if there are any changes when the modal is shown
            });

            // Set initial states
            updateEditButtonState($('.modal'));
            calculateTotalPrice($('.quantity-input'));
        });
    </script>



    {{-- <script>
        $(document).ready(function() {
            function debounce(func, delay) {
                let timer;

                return function(...args) {
                    const context = this;
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            function updateEditButtonState(modal) {
                let isChanged = false;

                modal.find('.form-control, .crancy-wc__form-input').each(function() {
                    const originalValue = $(this).data('original');
                    const currentValue = $(this).val();

                    if (currentValue !== originalValue) {
                        isChanged = true;
                        return false;
                    }
                });

                const quantity = modal.find('.quantity-input').val();
                const productSelected = modal.find('.product-select').val();

                modal.find('#btn-submit').prop('disabled', !isChanged);
            }

            $('.modal').on('input change', function() {
                updateEditButtonState($(this));
            });

            $('.product-select').on('change', function() {
                validateForm($(this));
                calculateTotalPrice($(this));
            });

            $('.quantity-input').on('input', debounce(function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                validateForm($(this));

                if ($(this).val() === '' || $(this).val() == 0) {
                    $(this).closest('.modal-body').find('#total_price').val(0);
                } else {
                    calculateTotalPrice($(this));
                }
            }, 500));

            function calculateTotalPrice(quantityInput) {
                let selectedProduct = quantityInput.closest('.modal-body').find('.product-select').find(
                    ':selected');
                let price = selectedProduct.data('price') || 0;
                let quantity = quantityInput.val();

                if (quantity && price && quantity > 0) {
                    checkStock(quantity, selectedProduct.val(), price, quantityInput);
                } else {
                    quantityInput.closest('.modal-body').find('#total_price').val(0);
                }
            }

            function checkStock(quantity, productId, price, quantityInput) {
                if (productId) {
                    $.ajax({
                        url: '{{ route('check-stock') }}',
                        type: 'GET',
                        data: {
                            product_id: productId
                        },
                        success: function(response) {
                            const stok = response.stok;
                            let stockWarning = quantityInput.closest('.modal-body').find(
                                '#stock-warning');

                            if (quantity > stok) {
                                stockWarning.text(
                                    'Jumlah quantity melebihi stok produk yang tersedia. Stok: ' +
                                    stok);
                                quantityInput.closest('.modal-body').find('#total_price').val(0);
                                $('#btn-submit').prop('disabled', true);
                            } else {
                                stockWarning.text('');
                                const totalPrice = parseFloat(price) * parseInt(quantity);
                                quantityInput.closest('.modal-body').find('#total_price').val(totalPrice
                                    .toLocaleString('id-ID', {
                                        minimumFractionDigits: 0
                                    }));

                                validateForm(quantityInput);
                            }
                        }
                    });
                }
            }

            function validateForm(element) {
                let selectedProduct = element.closest('.modal-body').find('.product-select').val();
                let quantity = element.closest('.modal-body').find('.quantity-input').val();

                if (selectedProduct && quantity && quantity > 0) {
                    $('#btn-submit').prop('disabled', false);
                } else {
                    $('#btn-submit').prop('disabled', true);
                }
            }

            function updateEditButtonState(modal) {
                let isChanged = false;

                modal.find('.form-control, .crancy-wc__form-input').each(function() {
                    const originalValue = $(this).data('original');
                    const currentValue = $(this).val();

                    console.log(`Original: ${originalValue}, Current: ${currentValue}`);

                    if (currentValue !== originalValue) {
                        isChanged = true;
                        console.log("Change detected!");
                        return false;
                    }
                });

                console.log(`isChanged: ${isChanged}`);
                modal.find('#btn-submit').prop('disabled', !isChanged);
            }

            $('.modal').on('input change', function() {
                updateEditButtonState($(this));
            });

            $('#modal').on('show.bs.modal', function() {
                updateEditButtonState($(this));
            });
        });
    </script> --}}
@endsection
