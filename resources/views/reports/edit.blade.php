@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit product</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label>Nama product</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>category</label>
                    <input type="text" name="category" value="{{ $product->category }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" value="{{ $product->price }}" class="form-control" step="0.01"
                        required>
                </div>

                <button class="btn btn-success">Perbarui</button>
                <a href="{{ route('products.index') }}" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
@endsection
