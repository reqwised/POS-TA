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
                        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" required autofocus>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-3 col-form-label">Nominal <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="nominal" id="nominal" class="form-control" required>
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