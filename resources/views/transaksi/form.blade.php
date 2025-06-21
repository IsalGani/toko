@extends('layouts.master')

@section('title', 'Transaksi Baru')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Transaksi Baru</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('transaksi.tambah') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Produk</label>
                    <select name="product_id" class="form-control">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} - Rp{{ number_format($product->price) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
            </form>
            @if (session('cart'))
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th> {{-- Tambahkan kolom aksi --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('cart') as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>Rp{{ number_format($item['price']) }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rp{{ number_format($item['subtotal']) }}</td>
                                <td>
                                    <form action="{{ route('transaksi.hapus', $id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @endif
            @if (session('cart'))
                <form action="{{ route('transaksi.simpan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ now() }}">
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </form>
            @endif

        </div>
    </div>
@endsection
