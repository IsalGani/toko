@extends('layouts.master')
@section('title', 'Riwayat Pesanan')

@section('content')
    <h3>Riwayat Pesanan</h3>

    @forelse ($riwayat as $order)
        <div class="box">
            <div class="box-header">
                <strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}<br>
                <strong>Total Bayar:</strong> Rp{{ number_format($order->bayar) }}
            </div>
            <div class="box-body">
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
                        @foreach ($order->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name ?? 'Produk Dihapus' }}</td>
                                <td>Rp{{ number_format($detail->harga) }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp{{ number_format($detail->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p>Belum ada pesanan.</p>
    @endforelse
@endsection
