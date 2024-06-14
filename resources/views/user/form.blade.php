<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body mx-4 mt-3">
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" name="name" id="name" class="form-control" required autofocus><span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="email" name="email" id="email" class="form-control" required><span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-4 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <select name="role" id="role" class="custom-select" required>
                                <option value="">Pilih Role</option>
                                <option value="Pemantau Stok">Pemantau Stok</option>
                                <option value="Kasir">Kasir</option>
                            </select>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" name="password" id="password" class="form-control" required minlength="6"><span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_confirmation" class="col-sm-4 col-form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required data-match="#password"><span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <!-- <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-chevron-circle-left"></i> Batal</button> -->
                </div>
            </div>
        </form>
    </div>
</div>