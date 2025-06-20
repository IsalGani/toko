<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    //

    public function index()
    {
        $penjualan = Penjualan::with('user')->latest()->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $produk = Product::all();
        return view('penjualan.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|array',
            'jumlah' => 'required|array',
            'bayar' => 'required|numeric',
        ]);

        $total = 0;

        foreach ($request->produk_id as $i => $id) {
            $produk = Product::find($id);
            $total += $produk->harga * $request->jumlah[$i];
        }

        $penjualan = Penjualan::create([
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total_harga' => $total,
            'bayar' => $request->bayar,
        ]);

        foreach ($request->produk_id as $i => $id) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'product_id' => $id,
                'jumlah' => $request->jumlah[$i],
                'harga' => Product::find($id)->harga,
            ]);

            // Update stok
            Product::where('id', $id)->decrement('stok', $request->jumlah[$i]);
        }

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan');
    }
}
