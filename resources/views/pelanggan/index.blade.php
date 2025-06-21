@extends('layouts.master')

@section('title', 'Beranda Pelanggan')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Daftar Produk</h3>
        </div>

        @forelse ($products as $product)
            <div class="col-md-3">
                <div class="box box-widget">
                    <div class="box-body text-center">
                        <h4>{{ $product->name }}</h4>
                        <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="qty" value="1" min="1" class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <p class="text-muted">Tidak ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
@endsection
