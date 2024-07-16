@extends('layouts.master')

@section('title', 'Laporan Penjualan Barang')
@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan Penjualan Barang</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h5 class="card-title">Laporan Penjualan Barang {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h5>
                    <div class="float-right">
                        <button onclick="updatePeriode()" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Periode Laporan</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th width="35%">Nama</th>
                            <th width="20%">Total Produk Terjual</th>
                            <th>Jumlah Subtotal</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('terlaris.form')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('terlaris.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_produk'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('form[data-toggle="validator"]');

        form.addEventListener('submit', function (event) {
            var tanggalAwal = new Date(document.getElementById('tanggal_awal').value);
            var tanggalAkhir = new Date(document.getElementById('tanggal_akhir').value);

            if (tanggalAwal > tanggalAkhir) {
                event.preventDefault();
                Swal.fire({
                    title: "Perhatian!",
                    text: "Tanggal awal tidak boleh lebih besar dari tanggal akhir.",
                    icon: "warning",
                    confirmButtonColor: '#007bff',
                });
            }
        });
    });
</script>
@endpush