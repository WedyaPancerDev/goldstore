        <!-- Modal Tambah Biaya Operasional -->
        <div id="addBiayaOperasionalModal" class="modal fade" tabindex="-1"
            aria-labelledby="#addBiayaOperasionalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <form method="POST" action="{{ route('biaya-operasional.store') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fs-6" id="#addBiayaOperasionalModalLabel">Tambah Biaya Operasional Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3 form-group">
                            <label class="form-label" for="nama_biaya_operasional">Nama Biaya Operasional <span
                                    class="text-danger">*</span></label>
                            <input id="nama_biaya_operasional" class="crancy-wc__form-input fw-semibold" type="text"
                                name="nama_biaya_operasional" placeholder="Masukan nama Biaya Operasional" required />
                            @if ($errors->has('nama_biaya_operasional'))
                                <div class="pt-2">
                                    <span
                                        class="form-text fw-semibold text-danger">{{ $errors->first('nama_biaya_operasional') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Tambah Data</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>




        <!-- Modal Edit Biaya Operasional -->
        @foreach ($biaya_operasional as $data)
            <div id="editBiayaOperasionalModal-{{ $data->id }}" class="modal fade" tabindex="-1"
                aria-labelledby="editBiayaOperasionalModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form method="POST" action="{{ route('biaya-operasional.update', $data->id) }}"
                        class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title fs-6" id="editBiayaOperasionalModalLabel">Edit Biaya Operasional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="editNama">Nama Biaya Operasional <span
                                        class="text-danger">*</span></label>
                                <input id="editNamaBiayaOperasional" class="crancy-wc__form-input fw-semibold"
                                    type="text" name="nama_biaya_operasional"
                                    value="{{ $data->nama_biaya_operasional }}" required />
                                @if ($errors->has('nama_biaya_operasional'))
                                    <div class="pt-2">
                                        <span
                                            class="form-text fw-semibold text-danger">{{ $errors->first('nama_biaya_operasional') }}</span>
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
        @endforeach
