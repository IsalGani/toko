<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    CategoryController,
    ProductController,
    PenjualanController,
    PenjualanDetailController,
    PembelianController,
    PembelianDetailController,
    PengeluaranController,
    SettingController,
    UserController,
    StokController,
    LaporanController,
    ReportController,
    KeranjangController,
    PelangganController,
    BerandaController
};

Route::get('/', fn() => redirect()->route('login'));

// ===================================
// Dashboard (semua user)
// ===================================
Route::middleware(['auth', 'level:1,2'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ===================================
// Admin (Level 1)
// ===================================
Route::middleware(['auth', 'level:1'])->group(function () {
    // Produk
    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
    Route::post('/product/cetak-barcode', [ProductController::class, 'cetakBarcode'])->name('product.cetak_barcode');
    Route::resource('/product', ProductController::class);

    // Kategori
    Route::resource('/category', CategoryController::class);
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');




    // Stok
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');

    // User & Setting

    Route::resource('/pelanggan', PelangganController::class)->except(['show']);
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});

// ===================================
// Admin & Kasir (Level 1,2)
// ===================================
Route::middleware(['auth', 'level:1,2'])->group(function () {
    // Penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    // Transaksi
    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/tambah', [PenjualanController::class, 'addToCart'])->name('transaksi.tambah');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::delete('/transaksi/hapus/{id}', [PenjualanController::class, 'hapusItem'])->name('transaksi.hapus');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');


    // Kategori
    Route::resource('/category', CategoryController::class);
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');


    // Laporan ringkas
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');

    // Profil
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

    // Manajenemn User
    Route::resource('user', UserController::class);

    // Manajemen Pelanggan
    Route::get('/pelanggan', [UserController::class, 'pelangganIndex'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [UserController::class, 'pelangganCreate'])->name('pelanggan.create');
    Route::post('/pelanggan', [UserController::class, 'pelangganStore'])->name('pelanggan.store');
    Route::get('/pelanggan/{id}/edit', [UserController::class, 'pelangganEdit'])->name('pelanggan.edit');
    Route::put('/pelanggan/{id}', [UserController::class, 'pelangganUpdate'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [UserController::class, 'pelangganDestroy'])->name('pelanggan.destroy');
});



// ===================================
// Pelanggan (Level 0)
// ===================================
Route::middleware(['auth', 'level:0'])->group(function () {

    Route::get('/', [BerandaController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/produk', [\App\Http\Controllers\PelangganController::class, 'index'])->name('pelanggan.produk');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::get('/riwayat-pesanan', [KeranjangController::class, 'riwayat'])->name('checkout.riwayat');
    Route::get('/pesanan', [\App\Http\Controllers\PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/riwayat', [KeranjangController::class, 'riwayat'])->name('riwayat');



    // Profil    
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
});
