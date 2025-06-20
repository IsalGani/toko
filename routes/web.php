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
    ReportController
};

Route::get('/', fn () => redirect()->route('login'));

// Semua pengguna setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin (Level 1)
Route::middleware(['auth', 'level:1'])->group(function () {
    // // Master Data
    // Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    // Route::resource('/category', CategoryController::class);

    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
    Route::post('/product/cetak-barcode', [ProductController::class, 'cetakBarcode'])->name('product.cetak_barcode');
    Route::resource('/product', ProductController::class);

    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');

    // // Pengeluaran dan Pembelian
    // Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
    // Route::resource('/pengeluaran', PengeluaranController::class);

    // Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    // Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    // Route::resource('/pembelian', PembelianController::class)->except('create');

    // Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
    // Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
    // Route::resource('/pembelian_detail', PembelianDetailController::class)->except('create', 'show', 'edit');

    // Riwayat Penjualan
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

    // // Laporan
    // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    // Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
    // Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

    // Pengaturan
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});

// Admin & Kasir (Level 1,2)
Route::middleware(['auth', 'level:1,2'])->group(function () {
    // Transaksi Kasir
    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');

    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    // Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    // Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    // Route::resource('/transaksi', PenjualanDetailController::class)->except('create', 'show', 'edit');

    // Profil
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');

    // Laporan ringkas kasir
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
});
