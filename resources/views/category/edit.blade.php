@extends('layouts.master')

@section('title', 'Edit Kategori')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Edit Kategori</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_category">Nama Kategori</label>
                    <input type="text" name="nama_category" class="form-control" value="{{ $category->nama_category }}"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('category.index') }}" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
@endsection
