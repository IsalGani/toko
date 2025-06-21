@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Tambah Kategori</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_category">Nama Kategori</label>
                    <input type="text" name="nama_category" class="form-control" required autofocus>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('category.index') }}" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
@endsection
