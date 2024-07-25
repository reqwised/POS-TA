<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Member;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\carbon;

class JualController extends Controller
{

    private function generateKodeInvoice()
    {
        $now = Carbon::now('Asia/Jakarta');
        // Ambil tanggal, jam, dan menit saat ini dengan format YmdHis
        $date = $now->format('ymdHis');

        // Ambil jumlah penjualan yang dilakukan hari ini untuk menentukan nomor urut
        $todayCount = Penjualan::whereDate('created_at', $now->toDateString())->count() + 1;
    
        // Format nomor urut menjadi 5 digit dengan leading zeroes
        $number = str_pad($todayCount, 5, '0', STR_PAD_LEFT);

        // Gabungkan semua bagian untuk membuat kode_invoice
        return "{$date}/{$number}";
    }

    public function index(){
        $produk = Produk::all();
        $diskonsetting = Setting::first()->diskon ?? 0;
        return view('jual.index', compact('produk','diskonsetting'));
    }
    public function store(Request $request)
    {
        // Log the request data for debugging
        Log::info('Request data: ', $request->all());

        // Validasi data
        $request->validate([
            'id_member' => 'nullable|exists:member,id_member',
            'total_item' => 'required|integer',
            'total_harga' => 'required|numeric|min:0',
            'diskon' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'diterima' => 'required|numeric|min:0',
            'detail_items' => 'required'
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
            $penjualan->kode_invoice = $this->generateKodeInvoice(); 
            $penjualan->id_user = Auth::id(); // Mengambil ID user yang sedang login
            $penjualan->save();

            Log::info('Main transaction saved successfully', ['penjualan_id' => $penjualan->id]);

            $detailItems = json_decode($request->detail_items, true);
            foreach ($detailItems as $item) {
                Log::info('Saving detail item: ', $item); // Log detail item yang akan disimpan
                $penjualanDetail = new PenjualanDetail;
                $penjualanDetail->id_penjualan = $penjualan->id_penjualan;
                $penjualanDetail->id_produk = $item['id_produk'];
                $penjualanDetail->harga_jual = $item['harga'];
                $penjualanDetail->jumlah = $item['jumlah'];
                $penjualanDetail->diskon = $item['diskon'];
                $penjualanDetail->subtotal = $item['subtotal'];
                $penjualanDetail->save();

                $prod = Produk::find($item['id_produk']);
                if($prod){
                    $prod->stok -= $item['jumlah'];
                    $prod->save();
                }
                Log::info('Detail item saved successfully', ['penjualan_detail_id' => $penjualanDetail->id]); // Log detail item berhasil disimpan
            }
            
            Log::info('Transaction saved successfully');

            return redirect()->route('jual.selesai',$penjualan->id_penjualan)->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            Log::error('Error saving transaction: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi');
        }
    }

    
    public function selesai($id)
        {
            $penjualan = Penjualan::with('details')->find($id);

            if (!$penjualan) {
                return redirect()->route('jual.index')->with('error', 'Transaksi tidak ditemukan');
            }

            return view('jual.selesai', compact('penjualan'));
        }

    public function cetak($id)
    {
        $penjualan = Penjualan::with('details')->find($id);

        if (!$penjualan) {
            return redirect()->route('jual.index')->with('error', 'Transaksi tidak ditemukan');
        }

        // Buat logika untuk menampilkan atau mencetak nota, misalnya dengan menggunakan view khusus atau library PDF
        return view('jual.cetak', compact('penjualan'));
    }
}
