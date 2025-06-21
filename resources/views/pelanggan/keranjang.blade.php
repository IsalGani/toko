@extends('layouts.master')

@section('title', 'Keranjang')

@section('content')
    <h3>🛒 Keranjang Belanja</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (empty($cart))
        <p>Keranjang masih kosong.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Normal</th>
                    <th>Diskon</th>
                    <th>Harga Setelah Diskon</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $id => $item)
                    @php
                        $discount = $item['discount'] ?? 0;
                        $hargaDiskon = $item['harga_diskon'] ?? $item['price'] - $discount;
                        $subtotal = $item['subtotal'] ?? $hargaDiskon * $item['qty'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($discount, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($hargaDiskon, 0, ',', '.') }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('keranjang.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-success">Checkout Sekarang</button>
        </form>
    @endif
@endsection
