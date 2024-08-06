@extends('layouts.master')

@section('title', 'Transaksi Pembelian')
@push('css')
<style>
    .tampil-bayar {
        font-size: 3.5em;
    }
    .tampil-terbilang {}
    .table-pembelian tbody tr:last-child {
        display: none;
    }
    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            margin-top: 10px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Transaksi Pembelian</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header pb-0 border-bottom">
                    <div class="row">
                        <div class="col-lg-8">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th width="5%"><strong>Supplier</strong></th>
                                        <td><span class="px-2">:</span>{{ $supplier->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th><strong>Telepon</strong></th>
                                        <td><span class="px-2">:</span>{{ $supplier->telepon }}</td>
                                    </tr>
                                    <tr>
                                        <th><strong>Alamat</strong></th>
                                        <td><span class="px-2">:</span>{{ $supplier->alamat }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-lg-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Total Bayar</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0" style="display: block;">
                                    <div class="tampil-bayar text-right pr-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row mt-2">

                        <div class="col-lg-8">
                            <form class="form-produk">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="kode_produk" id="kode_produk" placeholder="Cari Produk">
                                    <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <div class="form-inline">
                                        <label class="mr-4">Pilih Produk</label>
                                        <button onclick="tampilProduk()" class="btn btn-primary" type="button"><i class="fas fa-search"></i> Cari Produk</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-sm table-bordered table-striped table-pembelian">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th width="10%">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th width="10%">Aksi</th>
                                </thead>
                            </table>
                        </div>

                        <div class="col-lg-4 mt-2">
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">

                                <div class="form-group">
                                    <label for="totalrp">Total</label>
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}">
                                </div>
                                <div class="form-group">
                                    <label for="bayar">Bayar</label>
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a type="button" href="{{ route('pembelian.index') }}" class="btn btn-danger"><i class="fas fa-window-close"></i> Batal</a>
                    <button type="submit" class="btn btn-primary btn-simpan float-right"><i class="fas fa-check"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian_detail.produk')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
        });
        table2 = $('.table-produk').DataTable({
            processing: true,
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'stok'},
                {data: 'harga_beli'},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
            ]
        });

        $(document).on('focus', '.quantity', function () {
            $(this).data('previousValue', $(this).val());
        });

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());
            let previousValue = $(this).data('previousValue');

            if (jumlah < 1 || jumlah > 1000) {
                $(this).val(previousValue);

                let message = jumlah < 1 ? "Jumlah tidak boleh kurang dari 1" : "Jumlah tidak boleh lebih dari 1000";

                Swal.fire({
                    title: "Perhatian!",
                    text: message,
                    icon: "warning",
                    confirmButtonColor: '#007bff',
                });

                return;
            }

            $(this).data('previousValue', jumlah);

            $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('.btn-simpan').on('click', function () {
            $('.form-pembelian').submit();
        });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    // function hideProduk() {
    //     $('#modal-produk').modal('hide');
    // }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        // hideProduk();
        tambahProduk();
    }

    function tambahProduk() {
        $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
    }

    function deleteData(url) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
        })
        .done((response) => {
            table.ajax.reload(() => loadForm($('#diskon').val()));
        })
        .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
        });
    }

    function loadForm(diskon = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
    }

    document.getElementById('diskon').addEventListener('input', function() {
        let value = parseInt(this.value) || 0;
        
        if (value < 0) {
            this.value = 0;
        } else if (value > 100) {
            this.value = 100;
        } else {
            this.value = value;
        }
    });

</script>
@endpush