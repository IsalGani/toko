<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    //

    public function index()
    {
        $penjualans = Penjualan::with('user')->latest()->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transaksi.form', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $request->jumlah;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['qty'] * $cart[$product->id]['price'];
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $request->jumlah,
                'subtotal' => $request->jumlah * $product->price
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            $total_harga = collect($cart)->sum('subtotal');

            $penjualan = Penjualan::create([
                'user_id' => auth()->id(),
                'tanggal' => now(),
                'total_harga' => $total_harga,
                'bayar' => $total_harga, // bisa ditambah field bayar manual kalau mau
            ]);

            foreach ($cart as $product_id => $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'product_id' => $product_id,
                    'jumlah' => $item['qty'],
                    'harga' => $item['price'],
                ]);

                // kurangi stok
                $produk = Product::find($product_id);
                if ($produk) {
                    $produk->stock -= $item['qty'];
                    $produk->save();
                }
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('transaksi.baru')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function notaKecil()
    {
        $penjualan = Penjualan::latest()->first();
        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id)->with('produk')->get();

        return view('transaksi.nota_kecil', compact('penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $penjualan = Penjualan::latest()->first();
        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id)->with('produk')->get();

        return view('transaksi.nota_besar', compact('penjualan', 'detail'));
    }

    public function hapusItem($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('user', 'details.product')->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }
}
