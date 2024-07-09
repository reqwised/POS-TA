@extends('layouts.master')

@section('title', 'Transaksi Penjualan')

@push('css')
<style>
    .hidden-column{
        display: none;
    }
    .tampil-bayar {
        font-size: 4.5em;
    }
    .tampil-terbilang {}
    .table-penjualan {}
    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            margin-top: 10px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-body mx-2">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <input tabindex="2" type="text" id="kodeProdukInput"class="form-control d-inline" placeholder="Masukkan Kode Produk">
                        </div>
                        <div class="col-sm-3">
                            <button tabindex="1" type="button" class="btn btn-primary" data-toggle="modal" data-target="#daftarProdukModal"><i class="fas fa-search"></i>
                                Cari Produk
                            </button>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered table-striped table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th class="hidden-column">ID Produk</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="15%">Jumlah</th>
                            <th width="15%">Diskon</th>
                            <th>Subtotal</th>
                            <th width="10%">Aksi</i></th>
                            <th>Stok</th>
                        </thead>
                        <tbody id="table-penjualan-body">
                        </tbody>
                    </table>

                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <form action="{{ route('jual.store') }}" method="POST" id="form-penjualan">
                                @csrf
                                <input type="hidden" id="id_member" name="id_member" value="">
                                <input type="hidden" id="total_item" name="total_item" value="">
                                <input type="hidden" id="total_harga" name="total_harga" value="">
                                <input type="hidden" id="diskon" name="diskon" value="">
                                <input type="hidden" id="bayar" name="bayar" value="">
                                <input type="hidden" id="diterima" name="diterima" value="">
                                <input type="hidden" id="detail_items" name="detail_items" value="">

                                <div class="form-group row">
                                    <label for="total" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="total" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member" class="col-sm-3 col-form-label">Member</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="member" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-sm-3 col-form-label">Diskon</label>
                                    <div class="col-lg-9">
                                        <input type="number" id="disc" class="form-control" value="0" oninput="applyDiscount()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-sm-3 col-form-label">Bayar</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="byr" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diterima" class="col-sm-3 col-form-label">Diterima</label>
                                    <div class="col-lg-9">
                                        <input type="number" id="cash" class="form-control" oninput="calculateChange()" value="{{ $penjualan->diterima ?? 0 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-sm-3 col-form-label">Kembali</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary"></div>
                            <div class="tampil-terbilang"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Stok tidak mencukupi untuk produk ini.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

@includeIf('jual.produk')
@endsection
@push('scripts')

<script>
    document.querySelector('.btn-simpan').addEventListener('click', function(event) {
        event.preventDefault();

        const member = document.getElementById('member').value;
        const totalItem = calculateTotalItems();
        const totalHarga = document.getElementById('total').value;
        const diskon = document.getElementById('disc').value;
        const bayar = document.getElementById('byr').value;
        const diterima = document.getElementById('cash').value;
        const detailItems = getDetailItems();

        document.getElementById('id_member').value = member;
        document.getElementById('total_item').value = totalItem;
        document.getElementById('total_harga').value = totalHarga;
        document.getElementById('diskon').value = diskon;
        document.getElementById('bayar').value = bayar;
        document.getElementById('diterima').value = diterima;
        document.getElementById('detail_items').value = JSON.stringify(detailItems);

        document.getElementById('form-penjualan').submit();
    });

    function getDetailItems() {
        const tbody = document.getElementById('table-penjualan-body');
        let items = [];

        tbody.querySelectorAll('tr').forEach(row => {
            const id_produk = row.cells[1].innerText;
            const kode = row.cells[2].innerText;
            const nama = row.cells[3].innerText;
            const harga = parseFloat(row.cells[4].innerText);
            const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
            const diskon = parseInt(row.querySelector('input[name="diskon"]').value);
            const subtotal = parseFloat(row.cells[7].innerText);

            items.push({
                id_produk: id_produk,
                kode: kode,
                nama: nama,
                harga: harga,
                jumlah: jumlah,
                diskon: diskon,
                subtotal: subtotal
            });
        });

        return items;
    }

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
                        <td width="5%">${index + 1}</td>
                        <td class="hidden-column"><span class="label label-success">${item.id_produk}</span></td>
                        <td><span class="badge badge-primary">${item.kode_produk}</span></td>
                        <td>${item.nama_produk}</td>
                        <td >${item.harga_jual}</td>
                        <td width="10%">${item.stok > 0 ? 
                            `<button type="button" class="btn btn-primary btn-sm" 
                                onclick="pilihProduk('${item.id_produk}', '${item.kode_produk}', '${item.nama_produk}', '${item.harga_jual}', '${item.stok}')">
                                Pilih
                            </button>` : 
                            '<span class="text-danger">Stok habis</span>'}
                        </td>`;
                    tbody.appendChild(row);
                });
            });
    }

    $('#daftarProdukModal').on('show.bs.modal', fetchProducts);

    function pilihProduk(id_produk, kode, nama, harga, stok) {
        const tbody = document.getElementById('table-penjualan-body');
        let existingRow = null;

        // Cek apakah produk sudah ada di tabel
        tbody.querySelectorAll('tr').forEach(row => {
            if (row.cells[1].innerText === id_produk.toString()) {
                existingRow = row;
            }
        });

        if (existingRow) {
            // Jika produk sudah ada, tambahkan jumlahnya
            const jumlahInput = existingRow.querySelector('input[name="jumlah"]');
            const newJumlah = parseInt(jumlahInput.value) + 1;
            if (newJumlah > stok) {
                const modalBody = document.querySelector('#warningModal .modal-body');
                modalBody.innerText = `Stok tidak mencukupi untuk produk "${nama}".`;
                $('#warningModal').modal('show');
                return;
            }
            jumlahInput.value = newJumlah;
            updateSubtotal(jumlahInput);
        } else {
            // Jika produk belum ada, tambahkan produk baru
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${no++}</td>
                <td class="hidden-column">${id_produk}</td>
                <td>${kode}</td>
                <td>${nama}</td>
                <td>${harga}</td>
                <td><input tabindex="${no+1}" type="number" class="form-control" name="jumlah" value="1" oninput="validateJumlah(this, ${stok})"></td>
                <td><input type="number" class="form-control" name="diskon" value="0" oninput="updateSubtotal(this)"></td>
                <td>${harga}</td>
                <td><button type="button" class="btn btn-danger btn-sm onclick="hapusProduk(this)"><i class="fa fa-trash"></i></button></td>
                <td>${stok}</td>
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
                if(data.stok > 0){
                    pilihProduk(data.id_produk, data.kode_produk, data.nama_produk, data.harga_jual, data.stok);
                    document.getElementById('kodeProdukInput').value = ''; // Clear input after adding product
                }
                else{
                    const modalBody = document.querySelector('#warningModal .modal-body');
                    modalBody.innerText = `Stok tidak mencukupi untuk produk "${data.nama_produk}".`;
                    $('#warningModal').modal('show');
                }
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
        const harga = parseFloat(row.cells[4].innerText);
        const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon = parseInt(row.querySelector('input[name="diskon"]').value);
        const subtotalCell = row.cells[7];
        const stok = row.cells[9].innerText;
        const kondisi = stok-jumlah+1;

        if(kondisi){
            const subtotal = (harga * jumlah) - diskon;
            subtotalCell.innerText = subtotal;
            calculateTotal();
        }
        else{
            const modalBody = document.querySelector('#warningModal .modal-body');
            modalBody.innerText = `Stok tidak mencukupi untuk produk ini.`;
            $('#warningModal').modal('show');
            row.querySelector('input[name="jumlah"]').value = stok;
            // Update jumlah kembali
            jumlah = stok;
        }
    }

    document.getElementById('kodeProdukInput').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const kodeProduk = document.getElementById('kodeProdukInput').value;
            if (kodeProduk) {
                cariProduk(kodeProduk);
            }
        }
    });

    document.addEventListener("keypress", event=>{
        console.log(event.key);
        if(event.key==='['){
            $('[tabindex= 1]').focus();
        }
    })

    function calculateTotal() {
        const tbody = document.getElementById('table-penjualan-body');
        let total = 0;

        tbody.querySelectorAll('tr').forEach(row => {
            const subtotal = parseFloat(row.cells[7].innerText);
            total += subtotal;
        });

        document.querySelector('.tampil-bayar').innerText = format_uang(total);
        document.getElementById('total').value = total;
        applyDiscount();
    }

    function applyDiscount() {
        const total = parseFloat(document.getElementById('total').value || 0);
        const diskon = parseFloat(document.getElementById('disc').value || 0);
        const totalSetelahDiskon = total - (total * (diskon / 100));
        document.getElementById('byr').value = totalSetelahDiskon;
        calculateChange();
    }

    function calculateChange() {
        const totalBayar = parseFloat(document.getElementById('byr').value || 0);
        const diterima = parseFloat(document.getElementById('cash').value || 0);
        const kembali = diterima - totalBayar;
        document.getElementById('kembali').value = kembali;
    }

    function validateJumlah(input, stok) {
        const jumlah = parseInt(input.value);
        if (jumlah > stok) {
            // Tampilkan modal peringatan
            const modalBody = document.querySelector('#warningModal .modal-body');
            modalBody.innerText = `Stok tidak mencukupi untuk produk ini.`;
            $('#warningModal').modal('show');
            
            // Setel kembali nilai jumlah ke stok maksimum
            input.value = stok;
        }
        updateSubtotal(input);
    }

    function format_uang(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }
</script>
@endpush
