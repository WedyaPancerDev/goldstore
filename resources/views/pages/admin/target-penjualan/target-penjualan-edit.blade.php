@extends('layouts.master')

@section('title')
    Edit Target Penjualan
@endsection

@section('title-section')
    Target Penjualan
@endsection

@section('content')
    <section class="container container__bscreen mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-end">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Target Penjualan</li>
                            <li class="breadcrumb-item active">Edit Target Penjualan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-12">
            <div class="crancy-body">
                <div class="crancy-dsinner">

                    <div class="form-group mt-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" value="{{ $user->fullname ?? '' }}"
                            readonly>
                    </div>


                    <form action="{{ route('manajemen-target-penjualan.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="card p-3 mt-4">
                            <div class="row align-items-center">
                                <!-- Select and search button -->
                                <div class="col-lg-8 d-flex align-items-center gap-3">
                                    <select name="search_month" id="search_month" class="form-select fw-semibold w-100">
                                        <option value="none" selected hidden>Pilih Bulan</option>
                                        @foreach ($months as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <button id="show-filtered-product" type="button" class="btn btn-success fw-bold w-100"
                                        disabled>
                                        Tampilkan
                                    </button>
                                </div>

                                <!-- Reset button -->
                                <div class="col-lg-2">
                                    <button id="btn-reset-item" type="button" class="btn btn-secondary fw-bold w-100">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="total" class="form-label">Total</label>
                            <input type="text" name="total" id="total" class="form-control" value="0"
                                disabled>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" id="status" class="form-control" readonly>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" id="update-target" class="btn btn-primary" disabled>Update
                                Target Penjualan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function unformatNumber(num) {
                return num.replace(/\./g, '');
            }

            $('#total').on('input', function() {
                var value = unformatNumber(this.value);

                value = value.replace(/[^0-9]/g, '');

                if (value !== '') {
                    this.value = formatNumber(value);
                } else {
                    this.value = '';
                }

                $('#update-target').prop('disabled', value.trim() === '' || value.trim() === '0');
            });

            $('#search_month').change(function() {
                if ($(this).val() !== "none") {
                    $('#show-filtered-product').prop('disabled', false);
                } else {
                    $('#show-filtered-product').prop('disabled', true);
                }
            });

            $('#show-filtered-product').click(function() {
                var selectedMonth = $('#search_month').val();

                $.ajax({
                    url: "{{ route('manajemen-target-penjualan.edits', $user->id) }}",
                    type: "GET",
                    data: {
                        month: selectedMonth
                    },
                    success: function(response) {
                        console.log("Response dari server:", response);
                        var total = response.total !== null ? response.total : 0;
                        var formattedTotal = formatNumber(
                            total); // format total agar mudah dibaca
                        $('#total').val(formattedTotal).prop('disabled', false);
                        $('#status').val(response.status || 'Data tidak ditemukan');
                    },
                    error: function() {
                        $('#total').val('0').prop('disabled', false);
                        $('#status').val('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });


            $('#btn-reset-item').click(function() {
                $('#search_month').val('none');
                $('#show-filtered-product').prop('disabled', true);
                $('#total').val('0').prop('disabled', true);
                $('#status').val('');
                $('#update-target').prop('disabled', true);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#total').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $(".js-select-2").select2({
                theme: "default",
            });
        });
    </script>
@endsection
