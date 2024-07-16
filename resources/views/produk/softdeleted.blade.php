@extends('layouts.master')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{ route('produk.index') }}">Produk</a></li>
    <li class="breadcrumb-item active">Stash</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Soft Deleted Produk</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $item->kode_produk }}<span>
                                    </td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->nama_kategori }}</td>
                                    <td>{{ format_uang($item->harga_beli) }}</td>
                                    <td>{{ format_uang($item->harga_jual) }}</td>
                                    <td>{{ format_uang($item->stok) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="restoreProduct({{ $item->id_produk }})">Pulihkan</button>
                                    </td>
                                </tr>
                            @endforeach
                            <script>
                                function restoreProduct(id) {
                                    console.log('restore id=');
                                    $.ajax({
                                        url: `{{ url('produk/restore') }}/${id}`,
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function() {
                                            location.reload();
                                        }
                                    });
                                }
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
