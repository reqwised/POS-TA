<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JualController extends Controller
{
    public function index(){
        $produk = Produk::all();
        return view('jual.index', compact('produk'));
    }
    public function store(Request $request)
{
    // Log the request data for debugging
    Log::info('Request data: ', $request->all());

    // Validasi data
    $request->validate([
        'id_member' => 'nullable|exists:member,id',
        'total_item' => 'required|integer',
        'total_harga' => 'required|numeric|min:0',
        'diskon' => 'required|numeric|min:0',
        'bayar' => 'required|numeric|min:0',
        'diterima' => 'required|numeric|min:0',
    ]);

    try {
        // Buat transaksi baru
        $penjualan = new Penjualan;
        $penjualan->id_member = $request->id_member;
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total_harga;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;
        $penjualan->id_user = Auth::id(); // Mengambil ID user yang sedang login
        $penjualan->save();

        Log::info('Transaction saved successfully');

        return redirect()->route('jual.index')->with('success', 'Transaksi berhasil disimpan');
    } catch (\Exception $e) {
        Log::error('Error saving transaction: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
    }
}

}
