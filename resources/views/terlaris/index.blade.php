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
                    <h5 class="card-title"><b>Laporan Barang dengan Jumlah Penjualan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</b></h5>
                    <div class="float-right">
                        <button onclick="updatePeriode()" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Periode Laporan</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama Produk</th>
                            <th>Total Produk Terjual</th>
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
        // Find the form element
        var form = document.querySelector('form[data-toggle="validator"]');

        // Add event listener for form submission
        form.addEventListener('submit', function (event) {
            // Get the value of tanggal_awal and tanggal_akhir
            var tanggalAwal = new Date(document.getElementById('tanggal_awal').value);
            var tanggalAkhir = new Date(document.getElementById('tanggal_akhir').value);

            // Check if tanggal_awal is greater than tanggal_akhir
            if (tanggalAwal > tanggalAkhir) {
                // Prevent form submission
                event.preventDefault();

                // Show error message
                Swal.fire({
                    title: "Gagal memproses data!",
                    text: "Tanggal awal tidak boleh lebih besar dari tanggal akhir.",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
                return;
            }
        });
    });
</script>
@endpush