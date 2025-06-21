<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Http\Controllers\Controller;

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

        $total = array_sum(array_map(fn($item) => $item['subtotal'] ?? 0, $cart));

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

    public function nota($id)
    {
        $penjualan = Penjualan::with(['details.product', 'user'])->findOrFail($id);

        if ($penjualan->user_id != auth()->id()) {
            abort(403);
        }

        return view('pelanggan.nota', compact('penjualan'));
    }

    public function cetakNota($id)
    {
        $penjualan = Penjualan::with(['details.product', 'user'])->findOrFail($id);

        if ($penjualan->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        $pdf = Pdf::loadView('pelanggan.nota_pdf', compact('penjualan'));
        return $pdf->stream('nota-' . $penjualan->id . '.pdf');
    }

    public function bayar(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong!');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['subtotal'] ?? 0;
        }, $cart));

        $bayar = $request->input('bayar');

        if ($bayar < $total) {
            return redirect()->route('keranjang.index')->with('error', 'Pembayaran kurang dari total.');
        }

        $penjualan = Penjualan::create([
            'user_id'     => auth()->id(),
            'tanggal'     => now(),
            'total_harga' => $total,
            'bayar'       => $bayar,
            'kembalian'   => $bayar - $total,
            'status'      => 'lunas',
        ]);

        foreach ($cart as $product_id => $item) {
            $product = Product::find($product_id);
            if (!$product || $product->stock < $item['qty']) {
                return redirect()->route('keranjang.index')->with('error', "Stok tidak cukup untuk {$item['name']}");
            }

            $product->stock -= $item['qty'];
            $product->save();

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'product_id'   => $product_id,
                'harga'        => $item['harga_diskon'],
                'jumlah'       => $item['qty'],
                'subtotal'     => $item['subtotal'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('keranjang.index')->with('success', 'Pembayaran berhasil! Kembalian: Rp' . number_format($bayar - $total, 0, ',', '.'));
    }
}
