<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;

class KeranjangController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pelanggan.keranjang', compact('cart'));
    }

    public function tambah(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $qty = (int) $request->qty;
        $discount = $product->discount ?? 0;
        $hargaDiskon = $product->price - $discount;

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['qty'] * $hargaDiskon;
        } else {
            $cart[$product->id] = [
                'name'         => $product->name,
                'price'        => $product->price,
                'discount'     => $discount,
                'harga_diskon' => $hargaDiskon,
                'qty'          => $qty,
                'subtotal'     => $hargaDiskon * $qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
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

        $total = array_sum(array_map(function ($item) {
            return $item['subtotal'] ?? 0;
        }, $cart));

        $penjualan = Penjualan::create([
            'user_id'     => auth()->id(),
            'tanggal'     => now(),
            'total_harga' => $total,
            'bayar'       => $total,
        ]);

        foreach ($cart as $product_id => $item) {
            $product = Product::find($product_id);

            if (!$product || $product->stock < $item['qty']) {
                return redirect()->route('keranjang.index')->with('error', "Stok tidak cukup untuk {$item['name']}");
            }

            $product->stock -= $item['qty'];
            $product->save();

            $hargaDiskon = $item['harga_diskon'] ?? ($item['price'] - ($item['discount'] ?? 0));
            $subtotal = $item['subtotal'] ?? $hargaDiskon * $item['qty'];

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'product_id'   => $product_id,
                'harga'        => $hargaDiskon,
                'jumlah'       => $item['qty'],
                'subtotal'     => $subtotal,
            ]);
        }

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
