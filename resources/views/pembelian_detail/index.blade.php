@extends('layouts.master')

@section('title', 'Transaksi Pembelian')
@push('css')
<style>
    .tampil-bayar {
        font-size: 4.5em;
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
                <div class="card-header">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td width="10%">Supplier</td>
                            <td>: {{ $supplier->nama }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $supplier->telepon }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $supplier->alamat }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-body mx-2">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk" placeholder="Cari Produk">
                                <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                            </div>
                            <div class="col-sm-3">
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

                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">

                                <div class="form-group row">
                                    <label for="totalrp" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                                    <div class="col-lg-9">
                                        <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}" min="0" max="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bayarrp" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8">
                            <div class="tampil-bayar text-center bg-primary rounded-top"></div>
                            <div class="tampil-terbilang p-2 bg-light text-dark rounded-bottom"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
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
        table2 = $('.table-produk').DataTable();

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

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
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
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail(errors => {
                    alert('Gagal menghapus data!');
                    return;
                })
            }
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

    // Event listener untuk memastikan nilai tidak kurang dari 0
    document.getElementById('diskon').addEventListener('input', function() {
        if (parseInt(this.value) < 0 || this.value === '') {
            this.value = 0; // Jika nilai kurang dari 0 atau kosong, set ke 0
        }
    });

    // Event listener untuk memastikan nilai tidak lebih dari 100
    document.getElementById('diskon').addEventListener('input', function() {
        if (parseInt(this.value) > 100) {
            this.value = 100; // Jika nilai lebih dari 100, set ke 100
        }
    });
</script>
@endpush