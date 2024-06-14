<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="{{ route('laporan.index') }}" method="get" data-toggle="validator" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Periode Laporan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body mx-4 mt-3">
                    <div class="form-group row">
                        <label for="tanggal_awal" class="col-sm-4 col-form-label">Tanggal Awal <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required autofocus value="{{ request('tanggal_awal') }}">
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-sm-4 col-form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <div class="col-lg-8">
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
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