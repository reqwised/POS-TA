@extends('layouts.master')

@section('title', 'Dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body text-center">
                    <h1>Selamat Datang</h1>
                    <h2>Anda login sebagai <span class="badge badge-dark">KASIR</span></h2>
                    <br><br>
                    <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-lg">Transaksi Baru</a>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection