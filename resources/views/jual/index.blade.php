@extends('layouts.master')

@push('css')
<style>
    .hidden-column{
        display: none;
    }
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
    <li class="breadcrumb-item active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">

                <div>
                    <button tabindex="1" type="button" class="btn btn-primary" data-toggle="modal" data-target="#daftarProdukModal">
                        Lihat Daftar Produk
                    </button>
                    <input tabindex="2" type="text" id="kodeProdukInput" class="form-control d-inline" placeholder="Masukkan Kode Produk" style="width: 200px; display: inline-block;">
                </div>

                <table class="table table-striped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th class="hidden-column">ID Produk</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                        <th>Stok</th>
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
                            <input type="number" id="disc" class="form-control" value="0" oninput="applyDiscount()">
                        </div>
                        <div class="form-group">
                            <label for="bayar">Bayar</label>
                            <input type="text" id="byr" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="diterima">Diterima</label>
                            <input type="number" id="cash" class="form-control" oninput="calculateChange()" value='100000'>
                        </div>
                        <div class="form-group">
                            <label for="kembali">Kembali</label>
                            <input type="text" id="kembali" class="form-control" readonly>
                        </div>
                    </div>
                    <form action="{{ route('jual.store') }}" method="POST" id="form-penjualan">
                        @csrf
                        <input type="hidden" id="id_member" name="id_member" value="">
                        <input type="hidden" id="total_item" name="total_item" value="">
                        <input type="hidden" id="total_harga" name="total_harga" value="">
                        <input type="hidden" id="diskon" name="diskon" value="">
                        <input type="hidden" id="bayar" name="bayar" value="">
                        <input type="hidden" id="diterima" name="diterima" value="">
                        <input type="hidden" id="detail_items" name="detail_items" value="">
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
                            const diskon = document.getElementById('disc').value;
                            const bayar = document.getElementById('byr').value;
                            const diterima = document.getElementById('cash').value;
                            const detailItems = getDetailItems();
                    
                            // Isi input hidden
                            document.getElementById('id_member').value = member;
                            document.getElementById('total_item').value = totalItem;
                            document.getElementById('total_harga').value = totalHarga;
                            document.getElementById('diskon').value = diskon;
                            document.getElementById('bayar').value = bayar;
                            document.getElementById('diterima').value = diterima;
                            document.getElementById('detail_items').value = JSON.stringify(detailItems);
                    
                            // Submit the form
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
                    
                </div>
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

<!-- Modal Warning -->
  

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
                        <td class="hidden-column"><span class="label label-success">${item.id_produk}</span></td>
                        <td>${item.kode_produk}</td>
                        <td>${item.nama_produk}</td>
                        <td>${item.harga_jual}</td>
                        <td>${item.stok > 0 ? 
                            `<button type="button" class="btn btn-primary btn-xs btn-flat" 
                                onclick="pilihProduk('${item.id_produk}', '${item.kode_produk}', '${item.nama_produk}', '${item.harga_jual}', '${item.stok}')">
                                <i class="fa fa-check-circle"></i> Pilih
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
                <td><button type="button" class="btn btn-danger btn-xs btn-flat" onclick="hapusProduk(this)"><i class="fa fa-trash"></i></button></td>
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
