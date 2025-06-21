@extends('layouts.master')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
            {{ session('error') }}
        </div>
    @endif


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">🎉 Produk Promo</h3>
        </div>

        <div class="box-body">
            @if ($promoProducts->isEmpty())
                <p>Tidak ada produk promo saat ini.</p>
            @else
                <div class="row">
                    @foreach ($promoProducts as $promo)
                        <div class="col-md-3">
                            <div class="box box-widget text-center">
                                <div class="box-body">
                                    <h4>{{ $promo->name }}</h4>
                                    <p>
                                        <del>Rp{{ number_format($promo->price, 0, ',', '.') }}</del><br>
                                        <strong class="text-danger">Diskon:
                                            Rp{{ number_format($promo->discount, 0, ',', '.') }}</strong><br>
                                        <strong class="text-success">
                                            Rp{{ number_format($promo->price - $promo->discount, 0, ',', '.') }}
                                        </strong>
                                    </p>
                                    @if (auth()->user()->level == 0)
                                        <form action="{{ route('keranjang.tambah') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $promo->id }}">
                                            <input type="number" name="qty" value="1" min="1"
                                                class="form-control mb-2">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-cart-plus"></i> Beli
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Bagian daftar semua produk --}}
    @include('products.partials.all_products', ['products' => $products])
@endsection
