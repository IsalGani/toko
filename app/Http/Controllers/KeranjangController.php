<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Http\Controllers\Controller;

class KeranjangController extends Controller
{
    //
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pelanggan.keranjang', compact('cart'));
    }

    public function tambah(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $request->qty;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['qty'] * $product->price;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $request->qty,
                'subtotal' => $product->price * $request->qty
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function hapus($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong!');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        // Simpan transaksi ke tabel penjualans
        $penjualan = \App\Models\Penjualan::create([
            'user_id' => auth()->id(),  // penting! auth()->id() akan mengisi ID user yang login
            'tanggal' => now(),
            'total_harga' => $total,
            'bayar' => $total,
        ]);

        foreach ($cart as $product_id => $item) {
            // Kurangi stok dulu, validasi stok jika ingin
            $product = \App\Models\Product::find($product_id);
            if (!$product || $product->stock < $item['qty']) {
                return redirect()->route('keranjang.index')->with('error', "Stok tidak cukup untuk {$item['name']}");
            }

            $product->stock -= $item['qty'];
            $product->save();

            // Simpan detail transaksi
            \App\Models\PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'product_id' => $product_id,
                'harga' => $item['price'],
                'jumlah' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('keranjang.index')->with('success', 'Pesanan berhasil disimpan!');
    }


    public function riwayat()
    {
        $riwayat = Penjualan::with(['details.product'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.riwayat', compact('riwayat'));
    }
}
