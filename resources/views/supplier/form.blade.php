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

                <div class="modal-body mx-2">
                    <div class="form-group">
                        <label for="nama">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Supplier .. (Wajib)"  data-error="Nama supplier tidak boleh kosong" required>
                        <span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="telepon">Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Nomor Telepon .. (Wajib)"  data-error="Nomor telepon tidak boleh kosong" required>
                        <span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control" placeholder="Masukkan Alamat Supplier .. (Opsional)"></textarea>
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