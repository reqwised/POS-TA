@extends('layouts.master')

@section('title', 'Penjualan Selesai')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Penjualan Selesai</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-primary alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    </div>
                    <div class="text-center">
                        <h2 class="mb-5">Proses Transaksi Selesai.</h2>
                        <button class="btn btn-danger" onclick="cetakNota({{ $penjualan->id_penjualan }})">Cetak Nota</button>
                        <a href="{{ route('jual.index') }}" class="btn btn-primary">Transaksi Baru</a>
                    </div>
                </div>
                <!-- <div class="card-footer">
                    <button class="btn btn-danger" onclick="cetakNota({{ $penjualan->id_penjualan }})">Cetak Nota</button>
                    <a href="{{ route('jual.index') }}" class="btn btn-primary float-right">Transaksi Baru</a>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    function cetakNota(id) {
        window.open(`/jual/cetak/${id}`, "", "width=625,height=500");
    }
</script>
@endsection
