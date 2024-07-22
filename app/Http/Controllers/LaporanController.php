<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getDataLR($awal, $akhir){
        $no = 1;
        $dataLR = array();
        $total_omset = 0;
        $total_hpp = 0;
    
        $akhir = Carbon::parse($akhir)->endOfDay();

        $penjualan_details = Penjualan::whereBetween('created_at', [$awal, $akhir])
            ->with('details.produk')
            ->get();
    
        foreach ($penjualan_details as $penjualan) {
            $pendapatan_kotor = $penjualan->bayar;
            $total_penjualan_bersih = 0;
    
            foreach ($penjualan->details as $detail) {
                $produk = $detail->produk;
                $penjualan_bersih = ($produk->harga_jual - $produk->harga_beli) * $detail->jumlah - $detail->diskon - $penjualan->diskon;
                $total_penjualan_bersih += $penjualan_bersih;
            }
    
            $total_omset += $pendapatan_kotor;
            $total_hpp += $total_penjualan_bersih;
    
            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['nomor_faktur'] = $penjualan->kode_invoice;
            $row['pendapatan_kotor'] = 'Rp. ' . format_uang($pendapatan_kotor);
            $row['penjualan_bersih'] = number_format(($total_penjualan_bersih / $pendapatan_kotor) * 100, 2) . '% / Rp. ' . format_uang($total_penjualan_bersih); // Menambahkan penjualan bersih
            $row['margin'] = 'Rp. ' . format_uang($pendapatan_kotor - $total_penjualan_bersih);
    
            $dataLR[] = $row;
        }
    
        return $dataLR;
    }
    

    public function dataLR($awal ,$akhir){
        $dataLR = $this->getDataLR($awal, $akhir);

        return datatables()
            ->of($dataLR)
            ->make(true);
    }

    public function labarugi(Request $request){
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.labarugi', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $total_pendapatan += $pendapatan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['penjualan']   = 'Rp. '. format_uang($total_penjualan);
            $row['pembelian']   = 'Rp. '. format_uang($total_pembelian);
            $row['pengeluaran'] = 'Rp. '. format_uang($total_pengeluaran);
            $row['pendapatan']  = 'Rp. '. format_uang($pendapatan);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex'   => '',
            'tanggal'       => '',
            'penjualan'     => '',
            'pembelian'     => '',
            'pengeluaran'   => 'Total Pendapatan',
            'pendapatan'    => 'Rp. '. format_uang($total_pendapatan),
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

    public function exportPDF($awal, $akhir)
    {
        $data = $this->getData($awal, $akhir);
        $pdf  = PDF::loadView('laporan.pdf', compact('awal', 'akhir', 'data'));
        $pdf->setPaper('a4', 'potrait');
        
        return $pdf->stream('Laporan-pendapatan-'. date('Y-m-d-his') .'.pdf');
    }
}
