@extends('layouts.master')

@section('title', 'Kategori')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Tambah Kategori</button>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kategori</th>
                            @if (auth()->user()->role == 'Pemilik Toko')
                                <th width="10%">Aksi</th>
                            @endif
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('kategori.form')
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
                url: '{{ route('kategori.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
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
                            title: "Berhasil menyimpan data!",
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
                            text: "Nama kategori tidak boleh sama dengan yang sudah ada",
                            icon: "warning",
                            confirmButtonColor: '#007bff',
                        });
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kategori]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
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
                    Swal.fire({
                        title: "Gagal!",
                        text: "Nama kategori sedang digunakan oleh produk",
                        icon: "warning",
                        confirmButtonColor: '#007bff',
                    });
                });
            }
        });
    }
</script>
@endpush