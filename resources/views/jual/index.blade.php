@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">

                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#daftarProdukModal">
                        Lihat Daftar Produk
                    </button>
                    <input type="text" id="kodeProdukInput" class="form-control d-inline" placeholder="Masukkan Kode Produk" style="width: 200px; display: inline-block;">
                    <button type="button" class="btn btn-success" onclick="cariProduk()">Cari Produk</button>
                </div>

                <table class="table table-striped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody id="table-penjualan-body">
                        <!-- Produk akan ditambahkan di sini -->
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('jual.produk')

@endsection

@push('scripts')
<script>
    let no = 1;

    function fetchProducts() {
        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('product-list');
                tbody.innerHTML = '';
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td><span class="label label-success">${item.kode_produk}</span></td>
                        <td>${item.nama_produk}</td>
                        <td>${item.harga_jual}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-xs btn-flat" 
                                onclick="pilihProduk('${item.kode_produk}', '${item.nama_produk}', '${item.harga_jual}')">
                                <i class="fa fa-check-circle"></i> Pilih
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            });
    }

    $('#daftarProdukModal').on('show.bs.modal', fetchProducts);

    function pilihProduk(kode, nama, harga) {
        const tbody = document.getElementById('table-penjualan-body');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${no++}</td>
            <td>${kode}</td>
            <td>${nama}</td>
            <td>${harga}</td>
            <td><input type="number" class="form-control" name="jumlah" value="1" oninput="updateSubtotal(this)"></td>
            <td><input type="number" class="form-control" name="diskon" value="0" oninput="updateSubtotal(this)"></td>
            <td>${harga}</td>
            <td><button type="button" class="btn btn-danger btn-xs btn-flat" onclick="hapusProduk(this)"><i class="fa fa-trash"></i></button></td>
        `;

        tbody.appendChild(row);
        $('#daftarProdukModal').modal('hide');
    }

    function cariProduk() {
        const kodeProduk = document.getElementById('kodeProdukInput').value;
        fetch(`/api/products/${kodeProduk}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Produk tidak ditemukan');
                }
                return response.json();
            })
            .then(data => {
                pilihProduk(data.kode_produk, data.nama_produk, data.harga_jual);
                document.getElementById('kodeProdukInput').value = ''; // Clear input after adding product
            })
            .catch(error => {
                alert(error.message);
            });
    }

    function hapusProduk(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function updateSubtotal(input) {
        const row = input.parentNode.parentNode;
        const harga = parseFloat(row.cells[3].innerText);
        const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon = parseInt(row.querySelector('input[name="diskon"]').value);
        const subtotalCell = row.cells[6];

        const subtotal = (harga * jumlah) - diskon;
        subtotalCell.innerText = subtotal;
    }
    document.getElementById('kodeProdukInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const kodeProduk = document.getElementById('kodeProdukInput').value;
            if (kodeProduk) {
                cariProduk(kodeProduk);
            }
        }
    });
</script>
@endpush
