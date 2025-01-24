<!-- Create Modal -->
<div id="addHargaProduksiModal" class="modal fade" tabindex="-1" aria-labelledby="addHargaProduksiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="POST" action="{{ route('harga-produksi.store', $biaya->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fs-6" id="addHargaProduksiModalLabel">
                    Tambah Harga Produksi Baru untuk "{{ $biaya->nama_biaya_produksi }}"
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="mb-3 form-group">
                    <label class="form-label" for="harga">Harga <span class="text-danger">*</span></label>
                    <input id="harga" class="crancy-wc__form-input fw-semibold" type="number" name="harga"
                        placeholder="Masukan harga" required />
                    @if ($errors->has('harga'))
                        <div class="pt-2">
                            <span class="form-text fw-semibold text-danger">{{ $errors->first('harga') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-5 form-group">
                    <label class="form-label" for="bulan">Bulan <span class="text-danger">*</span></label>
                    <select id="bulan" class="form-select fw-semibold" name="bulan" required>
                        <option value="" selected disabled>Pilih Bulan</option>
                        @foreach ($months as $index => $month)
                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('bulan'))
                        <div class="pt-2">
                            <span class="form-text fw-semibold text-danger">{{ $errors->first('bulan') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mb-3 form-group">
                    <label class="form-label" for="tahun">Tahun <span class="text-danger">*</span></label>
                    <input id="tahun" class="crancy-wc__form-input fw-semibold" type="number" name="tahun"
                        placeholder="Masukan tahun" min="2000" max="2099" required />
                    @if ($errors->has('tahun'))
                        <div class="pt-2">
                            <span class="form-text fw-semibold text-danger">{{ $errors->first('tahun') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah Data</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
@foreach ($harga_produksi as $data)
    <div id="editHargaProduksiModal-{{ $data->id }}" class="modal fade" tabindex="-1"
        aria-labelledby="editHargaProduksiModalLabel-{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form method="POST" action="{{ route('harga-produksi.update', $data->id) }}" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fs-6" id="editHargaProduksiModalLabel-{{ $data->id }}">
                        Edit Harga Produksi "{{ $biaya->nama_biaya_produksi }}"
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="edit_harga_{{ $data->id }}">Harga <span
                                class="text-danger">*</span></label>
                        <input id="edit_harga_{{ $data->id }}" class="crancy-wc__form-input fw-semibold"
                            type="number" name="harga" value="{{ $data->harga }}" required />
                        @if ($errors->has('harga'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">{{ $errors->first('harga') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="edit_bulan_{{ $data->id }}">Bulan <span
                                class="text-danger">*</span></label>
                        <select id="edit_bulan_{{ $data->id }}" class="form-select fw-semibold" name="bulan"
                            required>
                            @foreach ($months as $index => $month)
                                <option value="{{ $index + 1 }}"
                                    {{ $data->bulan == $index + 1 ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('bulan'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">{{ $errors->first('bulan') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label" for="edit_tahun_{{ $data->id }}">Tahun <span
                                class="text-danger">*</span></label>
                        <input id="edit_tahun_{{ $data->id }}" class="crancy-wc__form-input fw-semibold"
                            type="number" name="tahun" value="{{ $data->tahun }}" min="2000"
                            max="2099" required />
                        @if ($errors->has('tahun'))
                            <div class="pt-2">
                                <span class="form-text fw-semibold text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="removeHargaProduksiModal-{{ $data->id }}" class="modal fade zoomIn" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="text-danger mb-4">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <h4 class="mb-2">Apakah kamu yakin?</h4>
                    <p class="text-muted mb-4">
                        Apakah kamu yakin ingin menghapus harga produksi ini?
                        <strong>Data yang dihapus tidak dapat diaktifkan kembali.</strong>
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('harga-produksi.destroy', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
