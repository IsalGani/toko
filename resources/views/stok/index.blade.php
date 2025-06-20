@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Stok Barang</h3>
        </div>
        <div class="box-body">
            <form method="GET" action="{{ route('stok.index') }}" class="form-inline" style="margin-bottom: 10px;">
                <div class="form-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari nama product...">
                </div>
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Cari</button>
            </form>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama product</th>
                        <th>category</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->category->nama ?? '-' }}</td>
                            <td>{{ $item->stok }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
