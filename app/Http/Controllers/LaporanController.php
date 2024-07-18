<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $total_pendapatan = 0;
        $total_struk = 0;
        $total_omset = 0;
        $total_hpp = 0;
    
        $penjualan_details = Penjualan::whereBetween('created_at', [$awal, $akhir])
            ->with('details.produk')
            ->get();

        foreach ($penjualan_details as $penjualan) {
            foreach ($penjualan->details as $detail) {
                $produk = $detail->produk;
                $pendapatan_kotor = $penjualan->bayar;
                $penjualan_bersih = ($produk->harga_jual - $produk->harga_beli) * $detail->jumlah - $detail->diskon - $penjualan->diskon;
                
                $total_omset += $pendapatan_kotor;
                $total_hpp += $penjualan_bersih;

                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['nomor_faktur'] = $penjualan->kode_invoice;
                $row['pendapatan_kotor'] = 'Rp. ' . format_uang($pendapatan_kotor);
                $row['penjualan_bersih'] = 'Rp. ' . format_uang($penjualan_bersih); // Menambahkan penjualan bersih
                $row['margin'] = number_format(($penjualan_bersih/$pendapatan_kotor)*100,2) .'%/Rp. '. format_uang($pendapatan_kotor - $penjualan_bersih);
    
                $dataLR[] = $row;
            }
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
