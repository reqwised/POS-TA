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

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $pengeluaranHariIni }}</h3>
                    <p>Pengeluaran Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pengeluaranBulanIni }}</h3>
                    <p>Pengeluaran Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $pengeluaranTahunIni }}</h3>
                    <p>Pengeluaran Tahun Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $pengeluaranTotal }}</h3>
                    <p>Total Seluruh Pengeluaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>        
    </div>

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
                    <p>Total Pengelola Stok</p>
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

    <div class="row">
        <!-- Grafik Pendapatan -->
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik <b>Pendapatan</b> Periode {{ tanggal_indonesia($tanggal_awal, false) }} - {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="salesChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Barang Terjual -->
        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik <b>Barang Terjual</b> Periode {{ tanggal_indonesia($tanggal_awal, false) }} - {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik <b>Omset</b> Periode {{ tanggal_indonesia($tanggal_awal, false) }} - {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="omsetChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
@push('scripts')

<script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    $(function() {
        // Grafik Pendapatan
        var salesChartCanvas = $('#salesChart').get(0).getContext('2d');

        var salesChartData = {
            labels: {!! json_encode($data_tanggal) !!},
            datasets: [{
                label: 'Pendapatan',
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: {!! json_encode($data_pendapatan) !!}
            }]
        };

        var salesChartOptions = {
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Tanggal'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        callback: function(value) { if (Number.isInteger(value)) { return value; } }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Pendapatan'
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            }
        };

        new Chart(salesChartCanvas, {
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
        });

        // Grafik Barang Terlaris
        var barChartCanvas = $('#barChart').get(0).getContext('2d');

        var barChartData = {
            labels: {!! json_encode($dataNama_produk) !!},
            datasets: [{
                label: 'Barang Terlaris',
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: {!! json_encode($dataJumlah_produk) !!}
            }]
        };

        var barChartOptions = {
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Nama Produk'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        callback: function(value) { if (Number.isInteger(value)) { return value; } }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Jumlah Terjual'
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });


        // Grafik Laporan Omset


        var omsetChartCanvas = $('#omsetChart').get(0).getContext('2d');

        var omsetChartData = {
            labels: {!! json_encode($data_tanggal1) !!},
            datasets: 
            [
            {
                label: 'Total Pendapatan',
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: {!! json_encode($total_omset) !!}
            },

            {
                label: 'Total Margin',
                backgroundColor: 'rgba(255, 0, 0, 0.7)',
                borderColor: 'rgba(255, 0, 0, )',
                borderWidth: 1,
                data: {!! json_encode($total_hpp) !!}
            }
            ]
        };

        var omsetChartOptions = {
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Tanggal'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        callback: function(value) { if (Number.isInteger(value)) { return value; } }
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Rupiah (Rp)'
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            }
        };

        new Chart(omsetChartCanvas, {
            type: 'bar',
            data: omsetChartData,
            options: omsetChartOptions
        });
        });
</script>
@endpush