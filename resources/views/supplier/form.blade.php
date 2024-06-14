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
                        <label for="nama" class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="nama" id="nama" class="form-control" required autofocus>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telepon" class="col-sm-3 col-form-label">Telepon <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="telepon" id="telepon" class="form-control" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-lg-9">
                            <textarea name="alamat" id="alamat" rows="3" class="form-control"></textarea>
                            <span class="help-block with-errors text-danger"></span>
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