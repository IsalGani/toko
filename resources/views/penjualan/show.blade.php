@extends('layouts.master')

@section('title', 'Detail Penjualan')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Detail Penjualan</h3>
        </div>
        <div class="box-body">
            <p><strong>Kasir:</strong> {{ $penjualan->user->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $penjualan->tanggal }}</p>
            <p><strong>Total:</strong> Rp{{ number_format($penjualan->total_harga) }}</p>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->details as $item)
                        <tr>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>Rp{{ number_format($item->harga) }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp{{ number_format($item->harga * $item->jumlah) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
