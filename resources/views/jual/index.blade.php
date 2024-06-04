@extends('layouts.master')

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" id="total" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="member">Member</label>
                            <input type="text" id="member" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="diskon">Diskon (%)</label>
                            <input type="number" id="diskon" class="form-control" value="0" oninput="applyDiscount()">
                        </div>
                        <div class="form-group">
                            <label for="bayar">Bayar</label>
                            <input type="text" id="bayar" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="diterima">Diterima</label>
                            <input type="number" id="diterima" class="form-control" oninput="calculateChange()">
                        </div>
                        <div class="form-group">
                            <label for="kembali">Kembali</label>
                            <input type="text" id="kembali" class="form-control" readonly>
                        </div>
                    </div>
                    <form action="{{ route('jual.store') }}" method="POST" id="form-penjualan">
                        @csrf
                        <input type="" id="id_member" name="id_member" value="">
                        <input type="" id="total_item" name="total_item" value="">
                        <input type="" id="total_harga" name="total_harga" value="">
                        <input type="" id="diskon" name="diskon" value="">
                        <input type="" id="bayar" name="bayar" value="">
                        <input type="" id="diterima" name="diterima" value="">
                        <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan">
                            <i class="fa fa-floppy-o"></i> Simpan Transaksi
                        </button>
                    </form>
                    
                    <script>
                        document.querySelector('.btn-simpan').addEventListener('click', function(event) {
                            event.preventDefault();
                    
                            // Mengambil nilai dari input
                            const member = document.getElementById('member').value;
                            const totalItem = calculateTotalItems();
                            const totalHarga = document.getElementById('total').value;
                            const diskon = document.getElementById('diskon').value;
                            const bayar = document.getElementById('bayar').value;
                            const diterima = document.getElementById('diterima').value;
                    
                            // Isi input hidden
                            document.getElementById('id_member').value = member;
                            document.getElementById('total_item').value = totalItem;
                            document.getElementById('total_harga').value = totalHarga;
                            document.getElementById('diskon').value = diskon;
                            document.getElementById('bayar').value = bayar;
                            document.getElementById('diterima').value = diterima;
                    
                            // Log values to console for debugging
                            console.log({
                                id_member: document.getElementById('id_member').value,
                                total_item: document.getElementById('total_item').value,
                                total_harga: document.getElementById('total_harga').value,
                                diskon: document.getElementById('diskon').value,
                                bayar: document.getElementById('bayar').value,
                                diterima: document.getElementById('diterima').value
                            });
                    
                            // Submit the form
                            document.getElementById('form-penjualan').submit();
                        });
                    
                        function calculateTotalItems() {
                            const tbody = document.getElementById('table-penjualan-body');
                            let totalItems = 0;
                    
                            tbody.querySelectorAll('tr').forEach(row => {
                                const jumlahInput = row.querySelector('input[name="jumlah"]');
                                if (jumlahInput) {
                                    const jumlah = parseInt(jumlahInput.value);
                                    if (!isNaN(jumlah)) {
                                        totalItems += jumlah;
                                    }
                                }
                            });
                    
                            return totalItems;
                        }
                    </script>
                    
                </div>
            </div>

            {{-- <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div> --}}
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
        let existingRow = null;

        // Cek apakah produk sudah ada di tabel
        tbody.querySelectorAll('tr').forEach(row => {
            if (row.cells[1].innerText === kode) {
                existingRow = row;
            }
        });

        if (existingRow) {
            // Jika produk sudah ada, tambahkan jumlahnya
            const jumlahInput = existingRow.querySelector('input[name="jumlah"]');
            jumlahInput.value = parseInt(jumlahInput.value) + 1;
            updateSubtotal(jumlahInput);
        } else {
            // Jika produk belum ada, tambahkan produk baru
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
        }
        calculateTotal();
    }

    function cariProduk(kodeProduk) {
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
        calculateTotal();
    }

    function updateSubtotal(input) {
        const row = input.parentNode.parentNode;
        const harga = parseFloat(row.cells[3].innerText);
        const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon = parseInt(row.querySelector('input[name="diskon"]').value);
        const subtotalCell = row.cells[6];

        const subtotal = (harga * jumlah) - diskon;
        subtotalCell.innerText = subtotal;
        calculateTotal();
    }

    document.getElementById('kodeProdukInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const kodeProduk = document.getElementById('kodeProdukInput').value;
            if (kodeProduk) {
                cariProduk(kodeProduk);
            }
        }
    });

    function calculateTotal() {
        const tbody = document.getElementById('table-penjualan-body');
        let total = 0;

        tbody.querySelectorAll('tr').forEach(row => {
            const subtotal = parseFloat(row.cells[6].innerText);
            total += subtotal;
        });

        document.querySelector('.tampil-bayar').innerText = format_uang(total);
        document.getElementById('total').value = total;
        applyDiscount();
    }

    function applyDiscount() {
        const total = parseFloat(document.getElementById('total').value || 0);
        const diskon = parseFloat(document.getElementById('diskon').value || 0);
        const totalSetelahDiskon = total - (total * (diskon / 100));
        document.getElementById('bayar').value = totalSetelahDiskon;
        calculateChange();
    }

    function calculateChange() {
        const totalBayar = parseFloat(document.getElementById('bayar').value || 0);
        const diterima = parseFloat(document.getElementById('diterima').value || 0);
        const kembali = diterima - totalBayar;
        document.getElementById('kembali').value = kembali;
    }

    function format_uang(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }
</script>
@endpush
