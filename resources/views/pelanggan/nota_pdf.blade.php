<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2 class="title">NOTA PEMBELIAN</h2>

    <table>
        <tr>
            <td><strong>Nama Pembeli</strong></td>
            <td>{{ $penjualan->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>ID Transaksi</strong></td>
            <td>#{{ $penjualan->id }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->details as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p><em>Terima kasih telah berbelanja di Toko Arfah!</em></p>
</body>

</html>
