                                                    <!-- Modal Konfirmasi Hapus -->
                                                    <div id="removeBiayaOperasionalModal-{{ $data->id }}"
                                                        class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header border-0">
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center p-4">
                                                                    <div class="text-danger mb-4">
                                                                        <i class="bi bi-trash display-4"></i>
                                                                    </div>
                                                                    <h4 class="mb-2">Apakah kamu yakin?</h4>
                                                                    <p class="text-muted mb-4">
                                                                        Apakah kamu yakin ingin menghapus biaya
                                                                        operasional ini?
                                                                        <strong>Biaya Operasional yang dihapus tidak
                                                                            dapat
                                                                            dikembalikan.</strong>
                                                                    </p>
                                                                    <div
                                                                        class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                        <button type="button"
                                                                            class="btn btn-light btn-sm"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('biaya-operasional.destroy', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger btn-sm">Iya,
                                                                                Nonaktifkan!</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
