<?php

use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    LaporanController,
    ProdukController,
    MemberController,
    PengeluaranController,
    PembelianController,
    PembelianDetailController,
    PenjualanController,
    SettingController,
    SupplierController,
    UserController,
    JualController,
    TerlarisController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'role:Pemilik Toko'], function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');
        Route::get('/laporan/labarugi',[LaporanController::class, 'labarugi'])->name('laporan.labarugi');
        Route::get('/laporan/laba-rugi/data/{awal}/{akhir}', [LaporanController::class, 'dataLR'])->name('laporan.laba_rugi.data');
        Route::get('/terlaris', [TerlarisController::class, 'index'])->name('terlaris.index');
        Route::get('/terlaris/data/{awal}/{akhir}', [TerlarisController::class, 'data'])->name('terlaris.data');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
        Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
        Route::resource('/pengeluaran', PengeluaranController::class);
    });

    Route::group(['middleware' => 'role:Pemilik Toko'], function () {
        Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
        Route::resource('/member', MemberController::class);
    });

    Route::group(['middleware' => 'role:Pemilik Toko,Kasir'], function () {
        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
        Route::get('/penjualan/{id}/nota', [PenjualanController::class, 'notaSelect'])->name('penjualan.nota_Select');
        Route::get('/jual', [JualController::class, 'index'])->name('jual.index');
        Route::get('/api/products', [ProdukController::class, 'getProducts']);
        Route::get('/api/products/{kode}', [ProdukController::class, 'getProductByKode']);
        Route::post('/jualstore', [JualController::class, 'store'])->name('jual.store');
        Route::get('/jual/selesai/{id}', [JualController::class, 'selesai'])->name('jual.selesai');
        Route::get('/jual/cetak/{id}', [JualController::class, 'cetak'])->name('jual.cetak');
        Route::get('/api/members', [MemberController::class,'getmembers']);
        Route::get('/api/member/{kode}', [MemberController::class,'getMemberByKode']);
    });

    Route::group(['middleware' => 'role:Pemilik Toko,Pengelola Stok'], function () {
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);
        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);
        Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
        Route::get('/pembelian/cancel',[PembelianController::class, 'cancel'])->name('pembelian.cancel');
        Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
        Route::resource('/pembelian', PembelianController::class)
            ->except('create');

        Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
        Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
        Route::resource('/pembelian_detail', PembelianDetailController::class)
            ->except('create', 'show', 'edit');
        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::resource('/produk', ProdukController::class);
        Route::get('/stash', [ProdukController::class, 'stash'])->name('produk.stash');
        Route::post('/produk/restore/{id}', [ProdukController::class, 'restore'])->name('produk.restore');
        
    });
 
    Route::group(['middleware' => 'role:Pemilik Toko,Kasir,Pengelola Stok'], function () {
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::resource('/produk', ProdukController::class);
    });

  

});