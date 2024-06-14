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
                        <label for="kode_produk" class="col-lg-3 control-label">Kode <span class="text-danger">&#42;</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="kode_produk" id="kode_produk" class="form-control" required autofocus>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_produk" class="col-lg-3 control-label">Nama <span class="text-danger">&#42;</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" required autofocus>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_kategori" class="col-lg-3 control-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select name="id_kategori" id="id_kategori" class="custom-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="merk" class="col-sm-2 col-form-label">Merk</label>
                        <div class="col-lg-9">
                            <input type="text" name="merk" id="merk" class="form-control">
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="harga_beli" class="col-lg-3 control-label">Harga Beli <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-lg-3  control-label">Harga Jual <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="diskon" class="col-lg-3  control-label">Diskon</label>
                        <div class="col-lg-9">
                            <input type="number" name="diskon" id="diskon" class="form-control" value="0">
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stok" class="col-lg-3  control-label">Stok <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="stok" id="stok" class="form-control" required value="1">
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <!-- <button type="button" class="btn btn-sm  btn-dark" data-dismiss="modal"><i class="fas fa-chevron-circle-left"></i> Batal</button> -->
                </div>
            </div>
        </form>
    </div>
</div>