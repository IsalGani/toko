@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Produk</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi (opsional)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <label>Diskon (%)</label>
                <input type="number" name="discount" class="form-control"
                    value="{{ old('discount', $product->discount ?? 0) }}" min="0" max="100">

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('products.index') }}" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
@endsection
