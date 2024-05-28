<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;


class JualController extends Controller
{
    public function index(){
        $produk = Produk::all();
        return view('jual.index', compact('produk'));
    }
}
