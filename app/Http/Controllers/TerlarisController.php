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
            $produk = Produk::find($penjualan->id_produk);

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['nama_produk'] = $produk->nama_produk;
            $row['jumlah'] = format_uang($penjualan->total_jumlah);
            $row['subtotal'] = 'Rp. ' . format_uang($penjualan->total_subtotal);
    
            $data[] = $row;
        }

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
