@extends('layouts.master')

@section('title', 'Penjualan')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nomor Faktur</th>
                            <th>Member</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Kasir</th>
                            <th width="10%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    let table, table1, kodeInvoice;

    $(function () {
        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'invoice'},
                {data: 'nama',render: function(data, type, row) {
            return `<span">${data}</span>`;
        }},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'kasir'},
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false,
                    render: function(data, type, row) {
                        @if (auth()->user()->role == 'Pemilik Toko')
                            return `
                                <button onclick= "showDetail('${row.detail_url}', '${row.kode_invoice}', '${row.tanggal}', '${row.nama}', '${row.kasir}')" class="btn btn-sm btn-warning text-light">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <button onclick="notaSelect('${row.nota_select}')" class="btn btn-sm btn-info text-light">
                                    <i class="fas fa-file"></i>
                                </button>`;
                        @elseif (auth()->user()->role == 'Kasir')
                            return `
                                <button onclick="showDetail('${row.detail_url}', '${row.kode_invoice}', '${row.tanggal}', '${row.nama}', '${row.kasir}')" class="btn btn-sm btn-warning text-light">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <button onclick="notaSelect('${row.nota_select}')" class="btn btn-sm btn-info text-light">
                                    <i class="fas fa-file"></i>
                                </button>`;
                        @endif
                    }
                },
            ]
        });

        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        })
    });

    function showDetail(url, kode_invoice, date, memb, casr) {
        var kodeInvoice = kode_invoice;  // Simpan kode_invoice dalam variabel lokal
        $('#modal-detail').modal('show');
        $('#kode-invoice').text(kodeInvoice);
        $('#date').text(date);  // Tampilkan date dalam modal
        $('#memb').text(memb);  // Tampilkan nama dalam modal
        $('#casr-invoice').text(casr);  // Tampilkan kasir dalam modal
        $('#casr-invoice').text(casr);

        table1.ajax.url(url);
        table1.ajax.reload();
    }
    function deleteData(url) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Gagal menghapus data!');
                    return;
                });
            }
        });
    }

    // print nota
    document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    function notaSelect(url, title) {
        popupCenter(url, title, 625, 500);
    }

    function notaBesar(url, title) {
        popupCenter(url, title, 900, 675);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title, 
        `
            scrollbars=yes,
            width  = ${w / systemZoom}, 
            height = ${h / systemZoom}, 
            top    = ${top}, 
            left   = ${left}
        `
        );

        if (window.focus) newWindow.focus();
    }
</script>
@endpush