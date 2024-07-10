<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\User;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }
        
        //TEST BARANG TERLARIS

        // Fetch data for top-selling products
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        $total_terlaris = PenjualanDetail::select('id_produk', DB::raw('CAST(SUM(jumlah) AS UNSIGNED) as total_jumlah'))
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->groupBy('id_produk')
            ->take(10)
            ->get();

            $dataNama_produk = [];
            $dataJumlah_produk = [];    

        // Populate $dataNama_produk and $dataJumlah_produk arrays
        foreach ($total_terlaris as $penjualan) {
            $produksi = Produk::find($penjualan->id_produk);
            if ($produksi) {
                $cleaned_nama_produk = trim($produksi->nama_produk, '"');
                $dataNama_produk[] = $cleaned_nama_produk;
                $dataJumlah_produk[] = $penjualan->total_jumlah;
            }
        }
        // dd($dataNama_produk, $dataJumlah_produk, $data_tanggal, $data_pendapatan);
        //TEST BARANG TERLARIS

        $tanggal_awal = date('Y-m-01');
        // Menambahkan data jumlah penjualan
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        $thisYear = date('Y');

        $penjualanHariIni = Penjualan::whereDate('created_at', $today)->sum('bayar');
        $penjualanBulanIni = Penjualan::where('created_at', 'LIKE', "$thisMonth%")->sum('bayar');
        $penjualanTahunIni = Penjualan::where('created_at', 'LIKE', "$thisYear%")->sum('bayar');
        $totalPenjualan = Penjualan::sum('bayar');

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');
        $total_terlaris = PenjualanDetail::select('id_produk', DB::raw('CAST(SUM(jumlah) AS UNSIGNED) as total_jumlah'))
            ->whereDate('created_at', '>=', $tanggal_awal)
            ->whereDate('created_at', '<=', $tanggal_akhir)
            ->groupBy('id_produk')
            ->take(10)
            ->get();

            $dataNama_produk = [];
            $dataJumlah_produk = [];    

        // Populate $dataNama_produk and $dataJumlah_produk arrays
        foreach ($total_terlaris as $penjualan) {
            $produksi = Produk::find($penjualan->id_produk);
            if ($produksi) {
                $cleaned_nama_produk = trim($produksi->nama_produk, '"');
                $dataNama_produk[] = $cleaned_nama_produk;
                $dataJumlah_produk[] = $penjualan->total_jumlah;
            }
        }

        $tanggal_awal = date('Y-m-01');
        // Menambahkan data jumlah penjualan
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        $thisYear = date('Y');

        $penjualanHariIni = Penjualan::whereDate('created_at', $today)->sum('bayar');
        $penjualanBulanIni = Penjualan::where('created_at', 'LIKE', "$thisMonth%")->sum('bayar');
        $penjualanTahunIni = Penjualan::where('created_at', 'LIKE', "$thisYear%")->sum('bayar');
        $totalPenjualan = Penjualan::sum('bayar');

        // Menghitung laba
        $totalPembelianHariIni = Pembelian::whereDate('created_at', $today)->sum('bayar');
        $totalPengeluaranHariIni = Pengeluaran::whereDate('created_at', $today)->sum('nominal');
        $labaHariIni = $penjualanHariIni - $totalPembelianHariIni - $totalPengeluaranHariIni;

        $totalPembelianBulanIni = Pembelian::where('created_at', 'LIKE', "$thisMonth%")->sum('bayar');
        $totalPengeluaranBulanIni = Pengeluaran::where('created_at', 'LIKE', "$thisMonth%")->sum('nominal');
        $labaBulanIni = $penjualanBulanIni - $totalPembelianBulanIni - $totalPengeluaranBulanIni;

        $totalPembelianTahunIni = Pembelian::where('created_at', 'LIKE', "$thisYear%")->sum('bayar');
        $totalPengeluaranTahunIni = Pengeluaran::where('created_at', 'LIKE', "$thisYear%")->sum('nominal');
        $labaTahunIni = $penjualanTahunIni - $totalPembelianTahunIni - $totalPengeluaranTahunIni;

        $totalPembelian = Pembelian::sum('bayar');
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $totalLaba = $totalPenjualan - $totalPembelian - $totalPengeluaran;

        // Format nilai penjualan dan laba
        $penjualanHariIni = 'Rp. ' . format_uang($penjualanHariIni);
        $penjualanBulanIni = 'Rp. ' . format_uang($penjualanBulanIni);
        $penjualanTahunIni = 'Rp. ' . format_uang($penjualanTahunIni);
        $totalPenjualan = 'Rp. ' . format_uang($totalPenjualan);

        $labaHariIni = 'Rp. ' . format_uang($labaHariIni);
        $labaBulanIni = 'Rp. ' . format_uang($labaBulanIni);
        $labaTahunIni = 'Rp. ' . format_uang($labaTahunIni);
        $totalLaba = 'Rp. ' . format_uang($totalLaba);

        // Menghitung jumlah user dengan role Kasir dan Pemantau Stok
        $jumlahKasir = User::where('role', 'Kasir')->count();
        $jumlahPemantauStok = User::where('role', 'Pemantau Stok')->count();

        if (auth()->user()->role == 'Pemilik Toko') {
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'penjualanHariIni', 'penjualanBulanIni', 'penjualanTahunIni', 'totalPenjualan', 'labaHariIni', 'labaBulanIni', 'labaTahunIni', 'totalLaba', 'jumlahKasir', 'jumlahPemantauStok', 'dataNama_produk', 'dataJumlah_produk'));
        } else if (auth()->user()->role == 'Kasir') {
            return view('kasir.dashboard');
        } else {
            return view('pemantau_stok.dashboard');
        }
    }
}
