<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pembelian;

class TerlarisController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('terlaris.index', compact('tanggalAwal', 'tanggalAkhir'));
    }
    public function getData($tanggalAwal, $tanggalAkhir){
        $no = 1;
        $data = array();
    
        $total_penjualan = PenjualanDetail::select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'), DB::raw('SUM(subtotal) as total_subtotal'))                                                                                 
                            ->whereDate('created_at', '>=', $tanggalAwal)
                            ->whereDate('created_at', '<=', $tanggalAkhir)
                            ->groupBy('id_produk')
                            ->orderByDesc('total_jumlah')
                            ->get();
    
        foreach ($total_penjualan as $penjualan) {
            //The code $produk = Produk::find($penjualan->id_produk); 
            //retrieves a record from the produk table using Laravel's Eloquent ORM, 
            //based on the id_produk value fetched from the $penjualan object.

            //find($penjualan->id_produk): Uses the find method provided by Eloquent to 
            //retrieve a record from the produk table where the primary key 
            //(id_produk) matches the value stored in $penjualan->id_produk
            $produk = Produk::find($penjualan->id_produk);

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['id_produk'] = $penjualan->id_produk;
            $row['nama_produk'] = $produk->nama_produk;
            $row['jumlah'] = $penjualan->total_jumlah;
            $row['subtotal'] = $penjualan->total_subtotal;
    
            $data[] = $row;
        }
        // Add an empty row if needed (optional)
        $data[] = [
            'DT_RowIndex' => '',
            'id_produk' => '',
            'nama_produk' => '',
            'jumlah' => '',
            'subtotal' => '',
        ];

        return $data;
    }

    public function data($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }
}
