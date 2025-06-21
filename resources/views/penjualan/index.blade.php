@extends('layouts.master')

@section('title', 'Riwayat Penjualan')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Riwayat Penjualan</h3>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualans as $p)
                        <tr>
                            <td>{{ $p->tanggal }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>Rp{{ number_format($p->total_harga) }}</td>
                            <td>
                                <a href="{{ route('penjualan.show', $p->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $penjualans->links() }}
        </div>
    </div>
@endsection
