<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body m-2">
                <div class="mb-3">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="10%"><strong>Invoice</strong></td>
                            <td>: <span id="kode-invoice"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>: <span id="date"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pelanggan</strong></td>
                            <td>:<span class="badge badge-primary" id="memb"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Kasir</strong></td>
                            <td>: <span id="casr-invoice"></span></td>
                        </tr>
                    </table>
                </div>
                <table class="table table-sm table-bordered table-striped table-detail">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>