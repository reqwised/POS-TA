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
                        <label for="name">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama Pengguna .. (Wajib)" data-error="Nama pengguna tidak boleh kosong" required><span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: example@gmail.com .. (Wajib)" data-error="Email pengguna tidak boleh kosong" required><span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="custom-select" data-error="Role user tidak boleh kosong" required>
                            <option value="">- Pilih Role -</option>
                            <option value="Pemantau Stok">Pemantau Stok</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                        <span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password Minimal 6 Karakter" data-error="Password harus diisi minimal 6 karakter" required minlength="6"><span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Minimal 6 Karakter" data-error="Konfirmasi password anda dengan benar" required data-match="#password"><span class="help-block with-errors text-danger"></span>
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