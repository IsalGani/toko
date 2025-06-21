@extends('layouts.master')

@section('title', 'Keranjang')

@section('content')
    <h3>Keranjang Belanja</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (empty($cart))
        <p>Keranjang masih kosong.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp{{ number_format($item['price']) }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>Rp{{ number_format($item['subtotal']) }}</td>
                        <td>
                            <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('keranjang.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-success">Checkout Sekarang</button>
        </form>
    @endif
@endsection
