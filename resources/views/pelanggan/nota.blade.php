@extends('layouts.master')

@section('title', 'Nota Pembelian')

@section('content')
    <div class="box">
        <div class="box-header with-border text-center">
            <h3>🧾 Nota Pembelian</h3>
        </div>
        <div class="box-body">
            <p><strong>Tanggal:</strong> {{ $penjualan->tanggal->format('d M Y H:i') }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $penjualan->user->name }}</p>

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
                    @foreach ($penjualan->details as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td><strong>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('keranjang.riwayat') }}" class="btn btn-default">← Kembali ke Riwayat</a>
            <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
        </div>
    </div>
@endsection
