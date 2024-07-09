<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mx-2">
                        <label for="nama_kategori">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori .. (Wajib)" data-error="Nama kategori tidak boleh kosong" required>
                        <span class="help-block with-errors text-danger"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>