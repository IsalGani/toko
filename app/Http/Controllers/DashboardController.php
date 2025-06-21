<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Pengeluaran;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $level = auth()->user()->level;

        if ($level == 1) { // ADMIN
            $category = Category::count();
            $product = Product::count();

            // Pendapatan Harian
            $tanggal_awal = date('Y-m-01');
            $tanggal_akhir = date('Y-m-d');
            $data_tanggal = [];
            $data_pendapatan = [];

            while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
                $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

                $total_penjualan = Penjualan::whereDate('created_at', $tanggal_awal)->sum('bayar');

                $data_pendapatan[] = $total_penjualan;

                $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
            }

            $stok_rendah = Product::where('stok', '<', 10)->get();

            return view('admin.dashboard', compact(
                'category',
                'product',
                'data_tanggal',
                'data_pendapatan',
                'stok_rendah'
            ));
        }

        if ($level == 2) { // KASIR
            return view('kasir.dashboard');
        }

        if ($level == 0) { // PELANGGAN
            return view('pelanggan.index');
        }

        abort(403); // Role tidak dikenal
    }
}
