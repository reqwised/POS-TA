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
                    <h2 class="alert alert-primary alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fas fa-check"></i> Berhasil
                    </h2>
                    <div class="text-center">
                        <h2>Transaksi telah disimpan.</h2>
                        <br><br>
                        <a tabindex="1" href="{{ route('jual.index') }}" class="btn btn-primary btn-lg">Transaksi Baru</a>
                        <button tabindex="2" class="btn btn-danger btn-lg" onclick="cetakNota({{ $penjualan->id_penjualan }})">Cetak Nota</button>
                    </div>
                </div>
                <div class="card-footer">
                </div>
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
