@extends('layouts.master')

@section('title', 'Member')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Member</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <button tabindex="1" onclick="addForm('{{ route('member.store') }}')" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Tambah Member</button>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="form-member">
                        @csrf
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <th width="5%">No</th>
                                <th width="10%">Kode</th>
                                <th>Nama</th>
                                <th width="15%">Telepon</th>
                                <th width="40%">Alamat</th>
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

@includeIf('member.form')
@endsection

@push('scripts')
<script>

    document.addEventListener("keypress", event=>{
        console.log(event.key);
        if(event.key==='+'){
            $('[tabindex= 1]').focus();
        }
    })

    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('member.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_member'},
                {data: 'nama'},
                {data: 'telepon'},
                {data: 'alamat'},
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
                        title: "Gagal menyimpan data!",
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
        $('#modal-form .modal-title').text('Tambah Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Member');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=telepon]').val(response.telepon);
                $('#modal-form [name=alamat]').val(response.alamat);
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
</script>
@endpush