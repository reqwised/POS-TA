@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button onclick="updatePeriode()" class="btn btn-primary"><i class="fas fa-exchange-alt"></i> Periode</button>
                    <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-danger"><i class="far fa-file-pdf"></i> PDF</a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Penjualan</th>
                            <th>Pembelian</th>
                            <th>Pengeluaran</th>
                            <th>Pendapatan</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan.form')
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
                url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'penjualan'},
                {data: 'pembelian'},
                {data: 'pengeluaran'},
                {data: 'pendapatan'}
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
                    title: "Tanggal awal tidak boleh lebih besar dari tanggal akhir.",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
                return;
            }
        });
    });
</script>
@endpush