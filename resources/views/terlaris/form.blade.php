<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
        <form action="{{ route('terlaris.index') }}" method="get" data-toggle="validator" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Periode Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                
                <div class="modal-body mx-2">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" data-error="Tanggal awal tidak boleh kosong" required value="{{ request('tanggal_awal') }}">
                        <span class="help-block with-errors text-danger"></span>
                    </div>  

                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" data-error="Tanggal akhir tidak boleh kosong" required value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}">
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