@extends('layouts.master')

@section('title', 'Riwayat Pembelian')

@section('content')
    <h3>🕘 Riwayat Pembelian</h3>

    @if ($riwayat->isEmpty())
        <p>Belum ada transaksi.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $transaksi)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                        <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('nota.cetak', $transaksi->id) }}" class="btn btn-sm btn-info">🧾 Nota</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
