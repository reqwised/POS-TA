<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body m-2">
                <table class="table table-sm table-bordered table-striped table-produk">
                    <thead>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $item)
                            <tr>
                                <td width="7%">{{ $key+1 }}</td>
                                <td width="15%"><span class="badge badge-primary">{{ $item->kode_produk }}</span></td>
                                <td width="40%">{{ $item->nama_produk }}</td>
                                <td width="10%">{{ $item->stok }}</td>
                                <td>{{ $item->harga_beli }}</td>
                                <td width="13%">
                                    <a href="#" class="btn btn-primary btn-sm"
                                        onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->kode_produk }}')">
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>