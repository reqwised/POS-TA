<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            ->where('produk.softdel', 0) // Menambahkan kondisi softdel = 0
            // ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge badge-primary">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return '<span class="float-right">'. 'Rp. '. format_uang($produk->harga_beli) .'</span>';
            })
            ->addColumn('harga_jual', function ($produk) {
                return '<span class="float-right">'. 'Rp. '. format_uang($produk->harga_jual) .'</span>'; ;
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div>
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-sm btn-warning text-light"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'stok', 'harga_beli', 'harga_jual'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = Produk::latest()->first() ?? new Produk();

        $produk = Produk::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->softdel = true;
        $produk->save();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::findOrFail($id);
            $produk->softdel = true;
            $produk->save();
        }

        return response(null, 204);
    }

    public function getProducts(Request $request)
    {
        $query = Produk::orderBy('nama_produk')->where('softdel', false);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('kode_produk', 'like', "%$search%")
                ->orWhere('nama_produk', 'like', "%$search%");
            });
        }

        $produk = $query->paginate(10);
        return response()->json($produk);

    }
    public function getProductByKode($kode)
    {
        $produk = Produk::where('kode_produk', $kode)
                        ->where('softdel',false)->first();

        if ($produk) {
            return response()->json($produk);
        } else {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
    }


    public function stash()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
                        ->select('produk.*', 'nama_kategori')
                        ->where('produk.softdel', true)
                        ->get();

        return view('produk.softdeleted', compact('produk'));
    }

    public function restore($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            $produk->softdel = false;
            $produk->save();
        }
        return response()->json(['success' => true]);
    }
}
