@extends('layouts.master')

@section('title', 'Laporan Omset')
@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan Omset</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h5 class="card-title">Laporan Omset {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}</h5>
                    <div class="float-right">
                        <button onclick="updatePeriode()" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Periode Laporan</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nomor Faktur</th>
                            <th>Pendapatan</th>
                            <th>HPP</th>
                            <th>Margin (%/Rp)</th>
                        </thead>
                        <tfoot>
                            <th colspan="2">Total</th>
                            <th id="total-pendapatan-kotor">Rp. 0</th>
                            <th id="total-penjualan-bersih">Rp. 0</th>
                            <th id="margintotal">Rp. 0</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan.formLR')
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
                url: '{{ route('laporan.laba_rugi.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nomor_faktur'},
                {data: 'pendapatan_kotor'},
                {data: 'margin'},
                {data: 'penjualan_bersih'}
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Rp. ,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages for pendapatan kotor
                totalPendapatanKotor = api
                    .column(2)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over all pages for penjualan bersih
                totalPenjualanBersih = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(2).footer()).html('Rp. ' + totalPendapatanKotor.toLocaleString());
                $(api.column(3).footer()).html('Rp. ' + totalPenjualanBersih.toLocaleString());
                $(api.column(4).footer()).html('Rp. ' + (totalPendapatanKotor - totalPenjualanBersih).toLocaleString());
            }
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
                    text: "Tanggal awal tidak boleh lebih dari tanggal akhir.",
                    icon: "warning",
                    confirmButtonColor: '#007bff',
                });
            }
        });
    });
</script>
@endpush
