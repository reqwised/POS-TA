<!-- File: resources/views/jual/produk.blade.php -->
<div class="modal fade" id="daftarProdukModal" tabindex="-1" role="dialog" aria-labelledby="daftarProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="daftarProdukModalLabel">Daftar Produk</h5>
                <div class="row-cols-1">
                    <input type="text" id="search">
                    <button type="submit">Cari Produk</button>
                </div>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga Beli</th>
                            <th><i class="fa fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody id="product-list">
                            <!-- Produk akan dimuat di sini melalui JavaScript -->
                        </tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
