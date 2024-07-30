<div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-supplier">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Supplier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body m-2">
                <table class="table table-sm table-bordered table-striped table-supplier">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($supplier as $key => $item)
                            <tr>
                                <td width="10%">{{ $key+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td width="15%">{{ $item->telepon }}</td>
                                <td width="45%">{{ $item->alamat }}</td>
                                <td width="10%">
                                    <a href="{{ route('pembelian.create', $item->id_supplier) }}" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i> Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>