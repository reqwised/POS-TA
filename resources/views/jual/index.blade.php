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
                            <th>Diskon (%)</th>
                            <th>Diskon (Rp)</th>
                            <th>Subtotal</th>
                            <th width="10%">Aksi</i></th>
                            <th>Stok</th>
                        </thead>
                        <tbody id="table-penjualan-body">
                        </tbody>
                    </table>
                    
                <div class="row mt-4">
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
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="text" id="total" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="kode_member">Kode Member</label>
                                <div class="input-group">
                                    <input type="text" id="kode_member" class="form-control" oninput="fetchMemberByKode()">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#daftarMemberModal"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama_member">Nama Member</label>
                                <input type="text" id="nama_member" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="diskon">Diskon (%)</label>
                                        <input type="number" id="disc_pr" class="form-control" value="0" oninput="disco_pr()" min="0" max="100">
                                    </div>
                                    <div class="col">
                                        <label for="disdiskon">Diskon (Rp)</label>
                                        <input type="text" id="disc_rp" class="form-control" value="0" oninput="disco_rp()" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bayar">Bayar</label>
                                <input type="text" id="byr" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="diterima">Diterima</label>
                                <input type="text" id="cash" class="form-control" oninput="formatCurrency(this)" onblur="removeFormatting(this)" value=''>
                            </div>
                            <div class="form-group">
                                <label for="kembali">Kembali</label>
                                <input type="text" id="kembali" class="form-control" readonly>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary text-center rounded"></div>
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
                <button type="button" class="btn btn-sm" data-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
    </div>
</div>

@includeIf('jual.produk')
@includeIf('jual.member')
@endsection

@push('scripts')
<script>
    document.querySelector('.tampil-bayar').innerText = format_uang(0);
    //nyimpan tabel penjualan
    document.querySelector('.btn-simpan').addEventListener('click', function(event) {
        event.preventDefault();

        // Mengambil nilai dari input
        const member = document.getElementById('kode_member').value;
        const totalItem = calculateTotalItems();
        const totalHarga = document.getElementById('total').value.replace(/[^,\d]/g, '').replace(/,00/,'');
        const diskon = document.getElementById('disc_rp').value.replace(/[^,\d]/g, '');
        const bayar = document.getElementById('byr').value.replace(/[^,\d]/g, '').replace(/,00/,'');
        const diterima = document.getElementById('cash').value.replace(/[^,\d]/g, '');
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

    //Penjualan_detail get masuk ke json
    function getDetailItems() {
        const tbody = document.getElementById('table-penjualan-body');
        let items = [];

        tbody.querySelectorAll('tr').forEach(row => {
            const id_produk = row.cells[1].innerText;
            const kode = row.cells[2].innerText;
            const nama = row.cells[3].innerText;
            const harga = unformatCurrency(row.cells[4].innerText);
            const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
            const diskon = parseInt(row.querySelector('input[name="diskon_rp"]').value);
            const subtotal = unformatCurrency(row.cells[8].innerText);

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

    let no = 1;
    let currentprodPage = 1;
    let searchTerm = '';

    function fetchProducts(page = 1, search = '') {
        fetch(`/api/products?page=${page}&search=${search}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('product-list');
                tbody.innerHTML = '';
                data.data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1 + (data.from - 1)}</td>
                        <td class="hidden-column">${item.id_produk}</td>
                        <td><span class="badge badge-primary">${item.kode_produk}</span></td>
                        <td>${item.nama_produk}</td>
                        <td>${item.harga_jual}</td>
                        <td width="10%">${item.stok > 0 ? 
                            `<button type="button" class="btn btn-primary btn-sm" 
                                onclick="pilihProduk('${item.id_produk}', '${item.kode_produk}', '${item.nama_produk}', '${item.harga_jual}', '${item.stok}','${item.diskon}')"><i class="fa fa-check-circle"></i> 
                                Pilih
                            </button>` : 
                            '<span class="text-danger">Stok habis</span>'}
                        </td>`;
                    tbody.appendChild(row);
                });
                setupPagination(data);
            });
    }

    function setupPagination(data) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        if (data.prev_page_url) {
            const prevButton = document.createElement('button');
            prevButton.innerText = 'Previous';
            prevButton.classList.add('btn', 'btn-primary');
            prevButton.onclick = () => fetchProducts(data.current_page - 1, searchTerm);
            pagination.appendChild(prevButton);
        }

        if (data.next_page_url) {
            const nextButton = document.createElement('button');
            nextButton.innerText = 'Next';
            nextButton.classList.add('btn', 'btn-primary');
            nextButton.onclick = () => fetchProducts(data.current_page + 1, searchTerm);
            pagination.appendChild(nextButton);
        }
    }

    document.getElementById('search-input').addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        fetchProducts(1, searchTerm);
    });

    $('#daftarProdukModal').on('show.bs.modal', () => fetchProducts(currentprodPage, searchTerm));


    function unformatCurrency(value) {
        return parseFloat(value.replace(/[Rp. ]/g, '').replace(/\./g, ''));
    }

    function pilihProduk(id_produk, kode, nama, harga, stok, diskon) {
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
                <td><p class="badge badge-primary m-0">${kode}</p></td>
                <td>${nama}</td>
                <td>${format_uang(harga)}</td>
                <td><input tabindex="${tbody.children.length + 2}" type="number" class="form-control" name="jumlah" value="1" oninput="validateJumlah(this, ${stok})"></td>
                <td><input type="number" class="form-control" name="diskon_pr" value="${diskon}" oninput="diskon_pr(this)"></td>
                <td><input type="number" class="form-control" name="diskon_rp" value="0" oninput="diskon_rp(this)"></td>
                <td>${format_uang(harga)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(this)"><i class="fa fa-trash"></i></button></td>
                <td>${stok}</td>
            `;

            tbody.appendChild(row);
            const diskonPrInput = row.querySelector('input[name="diskon_pr"]');
            diskon_pr(diskonPrInput);
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
                    pilihProduk(data.id_produk, data.kode_produk, data.nama_produk, data.harga_jual, data.stok, data.diskon);
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
        const harga = unformatCurrency(row.cells[4].innerText);
        let jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon = parseInt(row.querySelector('input[name="diskon_pr"]').value);
        const subtotalCell = row.cells[8];
        const stok = row.cells[10].innerText;
        const kondisi = stok - jumlah + 1;

        if (kondisi) {
            const subtotal = (harga * jumlah - (jumlah * harga * diskon / 100));
            row.querySelector('input[name="diskon_rp"]').value = parseInt(jumlah * harga * diskon / 100);
            subtotalCell.innerText = format_uang(subtotal);
            calculateTotal();
        } else {
            const modalBody = document.querySelector('#warningModal .modal-body');
            modalBody.innerText = `Stok tidak mencukupi untuk produk ini.`;
            $('#warningModal').modal('show');
            row.querySelector('input[name="jumlah"]').value = stok;
            // Update jumlah kembali
            jumlah = stok;
        }
    }

    function diskon_pr(input) {
        const row = input.parentNode.parentNode;
        const harga = unformatCurrency(row.cells[4].innerText);
        const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon_pr = parseFloat(row.querySelector('input[name="diskon_pr"]').value);
        const sub = harga * jumlah;
        const subtotalCell = row.cells[8];
        let subtotal_after_percent =parseInt(sub - ((diskon_pr / 100) * sub));
        let diskon_rp = sub - subtotal_after_percent;

        row.querySelector('input[name="diskon_rp"]').value = diskon_rp;
        subtotalCell.innerText = format_uang(subtotal_after_percent);
        calculateTotal();
    }

    function diskon_rp(input) {
        const row = input.parentNode.parentNode;
        const harga = unformatCurrency(row.cells[4].innerText);
        const jumlah = parseInt(row.querySelector('input[name="jumlah"]').value);
        const diskon_rp = parseInt(row.querySelector('input[name="diskon_rp"]').value);
        const sub = harga * jumlah;
        const subtotalCell = row.cells[8];
        let subtotal_after_dsc = sub - diskon_rp;
        let diskon_pr = (diskon_rp / sub) * 100;

        row.querySelector('input[name="diskon_pr"]').value = diskon_pr;
        subtotalCell.innerText = format_uang(subtotal_after_dsc);
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
            const subtotal = unformatCurrency(row.cells[8].innerText);
            total += subtotal;
        });

        document.querySelector('.tampil-bayar').innerText = format_uang(total);
        document.getElementById('total').value = format_uang(total);
        applyDiscount();
    }

    function format_uang(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function applyDiscount() {
        if(document.getElementById('disc_rp').value.replace(/[^,\d]/g, '') === "0" && document.getElementById('disc_pr').value === "0" ){
            let huehue = document.getElementById('total').value;
            document.getElementById('byr').value = huehue;
            calculateChange();
        }
        else if(document.getElementById('disc_pr').value === "0"){
            disco_rp();
        }
        else{
            disco_pr();
        }
    }
    function disco_pr(){
        const total = parseInt(document.getElementById('total').value.replace(/[^,\d]/g, '') || 0);
        const diskon_pr = parseFloat(document.getElementById('disc_pr').value || 0);
        let diskon = parseInt(total*(diskon_pr/100));
        let final = total-diskon;
        document.getElementById('disc_rp').value = "Rp. " + diskon;
        document.getElementById('byr').value = 'Rp. '+ final;
        calculateChange();
    }
    function disco_rp(){
        const total = parseInt(document.getElementById('total').value.replace(/[^,\d]/g, '') || 0);
        const diskon_rp = parseFloat(document.getElementById('disc_rp').value.replace(/[^,\d]/g, '') || 0);
        const totalSetelahDiskon = total - diskon_rp;
        let diskon_pr = (diskon_rp/total);
        document.getElementById('byr').value = 'Rp. '+ totalSetelahDiskon;
        document.getElementById('disc_pr').value = diskon_pr*100;
        document.getElementById('disc_rp').value = 'Rp. ' + diskon_rp;
        calculateChange();
    }

    function calculateChange() {
        const totalBayar = parseFloat(document.getElementById('byr').value.replace(/[^,\d]/g, '') || 0);
        const diterimaValue = document.getElementById('cash').value.replace(/[^,\d]/g, '');
        const diterima = parseFloat(diterimaValue || 0);
        const kembali = diterima - totalBayar;
        document.getElementById('kembali').value = 'Rp ' + kembali.toLocaleString('id-ID');
    }

    function validateJumlah(input, stok) {
        let jumlah = parseInt(input.value);

        if (jumlah < 1) {
            input.value = 1;
            const modalBody = document.querySelector('#warningModal .modal-body');
            modalBody.innerText = `Jumlah tidak boleh kurang dari satu.`;
            $('#warningModal').modal('show');
        } else if (jumlah > stok) {
            input.value = stok;
            const modalBody = document.querySelector('#warningModal .modal-body');
            modalBody.innerText = `Stok tidak mencukupi untuk produk ini.`;
            $('#warningModal').modal('show');
        }

        updateSubtotal(input);
    }

    function format_uang(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }

    function formatCurrency(input) {
        let value = input.value.replace(/[^,\d]/g, '');
        console.log("formatcurrency()"+value);
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        input.value = 'Rp ' + value;
        calculateChange();
    }

    function removeFormatting(input) {
        let value = input.value.replace(/[^,\d]/g, '');
        console.log("removeformatting"+value);
        input.value = 'Rp ' + (value ? parseInt(value, 10).toLocaleString('id-ID') : '');
        calculateChange();
    }

    function fetchMemberByKode() {
        const kodeMember = document.getElementById('kode_member').value;

        if (kodeMember.trim() === '') return;

        fetch(`/api/member/${kodeMember}`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    document.getElementById('id_member').value = '';
                    document.getElementById('nama_member').value = '';
                    document.getElementById('disc_pr').value = '0';
                    disco_pr();
                } else {
                    document.getElementById('id_member').value = data.id_member;
                    document.getElementById('nama_member').value = data.nama;
                    document.getElementById('disc_pr').value = {{$diskonsetting}};
                    disco_pr();
                }
            })
            .catch(error => console.error('Error:', error));
    }
    document.getElementById('kode_member').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const kodeMember = document.getElementById('kode_member').value;
            if (kodeMember) {
                ;
            }
        }
    });

    let currentPage = 1;

    function fetchMembers(search = '', page = 1) {
        fetch(`/api/members?search=${search}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('member-list');
                tbody.innerHTML = '';
                data.data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${(page - 1) * 10 + index + 1}</td>
                        <td><p class="badge badge-primary m-0">${item.kode_member}</p></td>
                        <td>${item.nama}</td>
                        <td><button type="button" class="btn btn-primary btn-sm" 
                            onclick="pilihMember('${item.id}', '${item.kode_member}', '${item.nama}')">
                            <i class="fa fa-check-circle"></i> Pilih
                        </button></td>`;
                    tbody.appendChild(row);
                });

                // Update pagination
                const pagination = document.getElementById('paginationmember');
                pagination.innerHTML = '';

                if (data.prev_page_url) {
                    const prevButton = document.createElement('button');
                    prevButton.classList.add('btn', 'btn-primary', 'mr-2');
                    prevButton.innerText = 'Previous';
                    prevButton.onclick = () => fetchMembers(search, data.current_page - 1);
                    pagination.appendChild(prevButton);
                }

                if (data.next_page_url) {
                    const nextButton = document.createElement('button');
                    nextButton.classList.add('btn', 'btn-primary', 'ml-2');
                    nextButton.innerText = 'Next';
                    nextButton.onclick = () => fetchMembers(search, data.current_page + 1);
                    pagination.appendChild(nextButton);
                }
            })
            .catch(error => console.error('Error:', error));
    }

function pilihMember(id, kode, nama) {
    document.getElementById('id_member').value = id;
    document.getElementById('kode_member').value = kode;
    document.getElementById('nama_member').value = nama;
    document.getElementById('disc_pr').value = {{$diskonsetting}};
    disco_pr();
    calculateTotal();
    $('#daftarMemberModal').modal('hide');
}

document.getElementById('search-member-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    fetchMembers(searchTerm,1);
});

$('#daftarMemberModal').on('show.bs.modal', () => fetchMembers('', 1));
</script>
@endpush
