@extends('layouts.master')

@section('title', 'Dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $penjualanHariIni }}</h3>
                    <p>Pendapatan Hari Ini</p>
                </div>
                <div class="icon">
                <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $penjualanBulanIni }}</h3>
                    <p>Pendapatan Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $penjualanTahunIni }}</h3>
                    <p>Pendapatan Tahun Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $totalPenjualan }}</h3>
                    <p>Total Seluruh Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>        
    </div>

    <!-- <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$labaHariIni }}</h3>
                    <p>Laba Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $labaBulanIni }}</h3>
                    <p>Laba Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $labaTahunIni }}</h3>
                    <p>Laba Tahun Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $totalLaba }}</h3>
                    <p>Total Seluruh Laba</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>        
    </div> -->

    <div class="row">
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahKasir }}</h3>
                    <p>Total Kasir</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahPemantauStok }}</h3>
                    <p>Total Pemantau Stok</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-xs-6">
            <a href="{{ route('kategori.index') }}">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $kategori }}</h3>
                        <p>Total Kategori</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-xs-6">
            <a href="{{ route('produk.index') }}">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $produk }}</h3>
                        <p>Total Produk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-xs-6">
            <a href="{{ route('member.index') }}">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $member }}</h3>
                        <p>Total Member</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-xs-6">
            <a href="{{ route('supplier.index') }}">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $supplier }}</h3>
                        <p>Total Supplier</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="barChart" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row (main row) -->
</div>
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(function() {
    // Get context with jQuery - using jQuery's .get() method.
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');

    var salesChartData = {
        labels: {{ json_encode($data_tanggal) }},
        datasets: [
            {
                label               : 'Pendapatan',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : {{ json_encode($data_pendapatan) }}
            }
        ]
    };

    var salesChartOptions = {
        pointDot : false,
        responsive : true
    };

    new Chart(salesChartCanvas, {
      type: 'line',
      data: salesChartData,
      options: salesChartOptions
    })});

    var barChartCanvas = $('#barChart').get(0).getContext('2d');

    var barChartData = {
        labels: {!! json_encode ($dataNama_produk) !!},
        datasets: [
            {
            label               : 'Pendapatan',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : {{ json_encode($dataJumlah_produk) }}
            }
        ]
    }

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    },
      datasetFill             : false
    }
    
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
</script>
@endpush