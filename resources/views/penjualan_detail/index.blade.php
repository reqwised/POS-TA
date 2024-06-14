@extends('layouts.master')

@section('title', 'Transaksi Penjualan')
@push('css')
<style>
    .tampil-bayar {
        font-size: 4.5em;
    }
    .tampil-terbilang {}
    .table-penjualan tbody tr:last-child {
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
    <li class="breadcrumb-item active">Transaksi Penjaualn</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body m-4">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_produk" class="col-sm-2 col-form-label">Pilih Produk</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" class="form-control"name="kode_produk" id="kode_produk">
                                    <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <span class="input-group-btn input-group-append">
                                        <button onclick="tampilProduk()" class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
    
                    <table class="table table-borderless table-striped table-penjualan">
                        <thead>
                            <th width="5%">#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="12%">Jumlah</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                            <th width="12%">Aksi</th>
                        </thead>
                    </table>
    
                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">
                                <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">
    
                                <div class="form-group row">
                                    <label for="totalrp" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kode_member" class="col-sm-3 col-form-label">Member</label>
                                    <div class="col-lg-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="kode_member" value="{{ $memberSelected->kode_member }}">
                                            <span class="input-group-btn input-group-append">
                                                <button onclick="tampilMember()" class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                                    <div class="col-lg-9">
                                        <input type="number" name="diskon" id="diskon" class="form-control" 
                                            value="{{ ! empty($memberSelected->id_member) ? $diskon : 0 }}" 
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bayarrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diterima" class="col-sm-3 col-form-label">Diterima</label>
                                    <div class="col-lg-9">
                                        <input type="number" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-sm-3 col-form-label">Kembali</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
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
                    <button type="submit" class="btn btn-primary btn-simpan"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.member')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body');

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#diskon').val());
            setTimeout(() => {
                $('#diterima').trigger('input');
            }, 300);
        });
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                Swal.fire({
                    title: "Jumlah tidak boleh kurang dari 1",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                Swal.fire({
                    title: "Jumlah tidak boleh lebih dari 10.000",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
                return;
            }

            $.post(`{{ url('/transaksi') }}/${id}`, {
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
                    Swal.fire({
                        title: "Gagal menyimpan data",
                        icon: "error",
                    });
                    return;
                });
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('#diterima').on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#diskon').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.btn-simpan').on('click', function () {
            $('.form-penjualan').submit();
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
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
            })
            .fail(errors => {
                Swal.fire({
                    title: "Gagal menyimpan data",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
                return;
            });
    }

    function tampilMember() {
        $('#modal-member').modal('show');
    }

    function pilihMember(id, kode) {
        $('#id_member').val(id);
        $('#kode_member').val(kode);
        $('#diskon').val('{{ $diskon }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideMember();
    }

    function hideMember() {
        $('#modal-member').modal('hide');
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
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    Swal.fire({
                        title: "Gagal menghapus data",
                        icon: "error",
                    });
                    return;
                });
            }
        });
    }

    function loadForm(diskon = 0, diterima = 0) {
    $('#total').val($('.total').text());
    $('#total_item').val($('.total_item').text());

    $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
        .done(response => {
            $('#totalrp').val('Rp. '+ response.totalrp);
            $('#bayarrp').val('Rp. '+ response.bayarrp);
            $('#bayar').val(response.bayar);
            $('.tampil-bayar').text('Bayar: Rp. '+ response.bayarrp);
            $('.tampil-terbilang').text(response.terbilang);

            // Check if the kembali value is negative, if so, set it to 0
            let kembaliRp = response.kembalirp < 0 ? 'Rp. 0' : 'Rp.' + response.kembalirp;
            let tampilan = response.kembalirp < 0 ? 'Bayar: Rp. '+ response.bayarrp : 'Kembali: Rp. '+ response.kembalirp;
            let terbilang = response.kembalirp < 0 ? response.terbilang : response.kembali_terbilang;

            $('#kembali').val(kembaliRp);
            $('.tampil-bayar').text(tampilan);
            $('.tampil-terbilang').text(terbilang);
        })
        .fail(errors => {
            Swal.fire({
                title: "Gagal menampilkan data",
                icon: "error",
            });
            return;
        })
}

</script>
@endpush