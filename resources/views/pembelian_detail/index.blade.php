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
                <div class="card-body">
                    <div class="row mt-2">

                        <div class="col-lg-4">
                            <h4>Transaksi Pembelian</h4>
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">

                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input class="form-control col-sm-11" value="{{ $supplier->nama }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="totalrp">Total</label>
                                    <input type="text" id="totalrp" class="form-control col-sm-11" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="diskon">Diskon</label>
                                    <div class="input-group col-sm-11 px-0">
                                        <input type="number" name="diskon" id="diskon" class="form-control " value="{{ $diskon }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        </div>
                                    </div>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="bayar">Bayar</label>
                                    <input type="text" id="bayarrp" class="form-control col-sm-11" readonly>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-8">
                            <h4>Daftar Pembelian</h4>
                            <form class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="kode_produk" id="kode_produk" placeholder="Masukkan Kode Produk">
                                        <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                        <input type="hidden" name="id_produk" id="id_produk">
                                    </div>
                                    <div class="col-sm-4">
                                        <button onclick="tampilProduk()" class="btn btn-primary" type="button"><i class="fas fa-search"></i> Pilih Produk</button>
                                    </div>
                                </div>
                            </form>
                            
                            <table class="table table-sm table-bordered table-striped table-pembelian mb-5">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th width="10%">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th width="7%">Aksi</th>
                                </thead>
                            </table>

                            <div class="card bg-primary mt-3">
                                <div class="card-header py-1">
                                    <h3 class="card-title">Total Bayar</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="tampil-bayar text-right pr-2"></div>
                                </div>
                            </div>
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
        let kode_produk = $('#kode_produk').val();
        let tableData = table.rows().data().toArray();
        let existingRow = tableData.find(row => row.kode_produk === kode_produk);

        console.log("Kode Produk dari Input:", kode_produk);
        console.log("Data Tabel:", tableData);
        console.log("Baris yang Ditemukan:", existingRow);

        if (existingRow) {
            // Ekstraksi nilai jumlah dari input HTML
            let jumlahInput = $(existingRow.jumlah).val(); // Ekstrak nilai dari HTML input
            let newJumlah = parseInt(jumlahInput) + 1;

            // Ambil ID detail pembelian dari atribut data-id pada input
            let idDetail = $(existingRow.jumlah).data('id');

            $.post(`{{ url('/pembelian_detail') }}/${idDetail}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': newJumlah
                })
                .done(response => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail(errors => {
                    console.error(errors);
                    alert('Tidak dapat menambahkan produk');
                    return;
                });
        } else {
            // Jika produk belum ada, tambahkan produk baru
            $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                .done(response => {
                    $('#kode_produk').focus();
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail(errors => {
                    console.error(errors);
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        }
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