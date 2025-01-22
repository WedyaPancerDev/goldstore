 <!-- Modal Tambah Biaya produksi -->
 <div id="addBiayaProduksiModal" class="modal fade" tabindex="-1" aria-labelledby="#addBiayaProduksiModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-scrollable">
         <form method="POST" action="{{ route('biaya-produksi.store') }}" class="modal-content">
             @csrf
             <div class="modal-header">
                 <h5 class="modal-title fs-6" id="#addBiayaProduksiModalLabel">Tambah Biaya Produksi Baru
                 </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <div class="modal-body p-4">
                 <div class="mb-3 form-group">
                     <label class="form-label" for="nama_biaya_produksi">Nama Biaya produksi <span
                             class="text-danger">*</span></label>
                     <input id="nama_biaya_produksi" class="crancy-wc__form-input fw-semibold" type="text"
                         name="nama_biaya_produksi" placeholder="Masukan nama Biaya produksi" required />
                     @if ($errors->has('nama_biaya_produksi'))
                         <div class="pt-2">
                             <span
                                 class="form-text fw-semibold text-danger">{{ $errors->first('nama_biaya_produksi') }}</span>
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
