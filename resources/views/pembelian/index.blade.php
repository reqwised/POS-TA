@extends('layouts.master')

@section('title', 'Pembelian')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pembelian</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <button onclick="addForm()" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Tambah Pembelian</button>
                    <!-- @empty(! session('id_pembelian'))
                    <a href="{{ route('pembelian_detail.index') }}" class="btn btn-sm btn-danger"><i class="fas fa-edit"></i> Edit</a>
                    @endempty -->
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped table-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th width="10%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false,
                    render: function(data, type, row) {
                        @if (auth()->user()->role == 'Pemilik Toko')
                            return `
                                <button onclick="showDetail('${row.detail_url}')" class="btn btn-sm btn-warning text-light">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <button onclick="deleteData('${row.delete_url}')" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>`;
                        @elseif (auth()->user()->role == 'Pengelola Stok')
                            return `
                                <button onclick="showDetail('${row.detail_url}')" class="btn btn-sm btn-warning text-light">
                                    <i class="fas fa-info-circle"></i>
                                </button>`;
                        @endif
                    }
                },
                ]
        });

        $('.table-supplier').DataTable();
        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        })
    });

    function addForm() {
        $('#modal-supplier').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
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