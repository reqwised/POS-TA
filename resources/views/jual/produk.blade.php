<div class="modal fade" id="daftarProdukModal" tabindex="-1" role="dialog" aria-labelledby="daftarProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="daftarProdukModalLabel">Daftar Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-2 mt-3">
                <input type="text" id="search-input" class="form-control" placeholder="Cari kode/nama produk...">
                <br>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga Beli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tbody id="product-list">
                        </tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#daftarProdukModal').on('shown.bs.modal', function () {
        $('#search-input').trigger('focus');
    });
    document.getElementById('search-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const productList = document.getElementById('product-list');
    const rows = productList.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const kode = row.cells[2].innerText.toLowerCase();
        const nama = row.cells[3].innerText.toLowerCase();
        if (kode.includes(searchTerm) || nama.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endpush