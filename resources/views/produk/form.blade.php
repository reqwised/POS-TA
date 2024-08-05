<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body mx-2">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="kode_produk">Kode Produk <span class="text-danger">&#42;</span></label>
                            <input type="text" name="kode_produk" id="kode_produk" class="form-control" placeholder="Kode Produk .. (Wajib)" data-error="Kode produk tidak boleh kosong" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_produk">Nama <span class="text-danger">&#42;</span></label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Masukkan Nama Produk .. (Wajib)" data-error="Nama produk tidak boleh kosong" required>
                        <span class="help-block with-errors text-danger"></span>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_kategori">Kategori <span class="text-danger">&#42;</span></label>
                            <select name="id_kategori" id="id_kategori" class="custom-select" data-error="Kategori tidak boleh kosong" required>
                                <option value="">- Pilih kategori -</option>
                                @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stok">Stok <span class="text-danger">&#42;</span></label>
                            <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan Jumlah Stok .. (Wajib)" data-error="Jumlah stok tidak boleh kosong" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="harga_beli">Harga Modal <span class="text-danger">&#42;</span></label>
                            <input type="number" name="harga_beli" id="harga_beli" placeholder="Contoh: 10000 .. (Wajib)" data-error="Harga modal tidak boleh kosong" class="form-control" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="harga_jual">Harga Jual <span class="text-danger">&#42;</span></label>
                            <input type="number" name="harga_jual" id="harga_jual" class="form-control" placeholder="Contoh: 15000 .. (Wajib)" data-error="Harga jual tidak boleh kosong" required>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="diskon">Diskon</label>
                            <div class="input-group">
                                <input type="number" name="diskon" id="diskon" class="form-control" data-error="Diskon tidak boleh kosong" value="0" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                </div>
                            </div>
                            <span class="help-block with-errors text-danger"></span>
                        </div>
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