        {{-- <!-- Modal Edit Biaya Operasional -->
        @foreach ($cabang as $data)
            <div id="editCabangModal-{{ $data->id }}" class="modal fade" tabindex="-1"
                aria-labelledby="editCabangModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form method="POST" action="{{ route('manajemen-cabang.update', $data->id) }}" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fs-6" id="editCabangModalLabel">Edit Cabang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="editNama">Nama Cabang <span
                                        class="text-danger">*</span></label>
                                <input id="editNamaCabang" class="crancy-wc__form-input fw-semibold" type="text"
                                    name="nama_cabang" value="{{ $data->nama_cabang }}" required />
                                @if ($errors->has('nama_cabang'))
                                    <div class="pt-2">
                                        <span
                                            class="form-text fw-semibold text-danger">{{ $errors->first('nama_cabang') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button id="btn-submit" type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach --}}
