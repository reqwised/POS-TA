@extends('layouts.master')

@section('title', 'Produk')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Tambah Produk</button>
                    <!-- @if (auth()->user()->role == 'Pemilik Toko')
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>
                    <a href="{{ route('produk.stash') }}" class="btn btn-sm btn-warning float-right"><i class="fa fa-recycle"></i> Stash</a>
                    @endif -->
                </div>
                <div class="card-body">
                    <form method="post" class="form-produk">
                        @csrf
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Modal</th>
                                <th>Jual</th>
                                <th width="10%">Diskon %</th>
                                <th>Stok</th>
                                @if (auth()->user()->role == 'Pemilik Toko')
                                <th width="10%">Aksi</th>
                                @endif
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'stok'},
                @if (auth()->user()->role == 'Pemilik Toko')
                {data: 'aksi', searchable: false, sortable: false},
                @endif
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        Swal.fire({
                            title: "Berhasil menyimpan data",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                        });
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: "Gagal!",
                            text: "Kode atau nama produk tidak boleh sama dengan yang sudah ada",
                            icon: "warning",
                            confirmButtonColor: '#007bff',
                        });
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=kode_produk]').val(response.kode_produk);
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Gagal menampilkan data!');
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
                .fail((errors) => {
                    alert('Gagal menghapus data!');
                    return;
                });
            }
        });
    }

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
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
                    $.post(url, $('.form-produk').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Gagal menampilkan data');
                        return;
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Perhatian!",
                text: "Pilih minimal 2 data yang akan dihapus",
                icon: "warning",
                confirmButtonColor: '#007bff',
            });
        }
    }
</script>
@endpush