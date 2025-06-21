<!DOCTYPE html>
<html>

<head>
    <title>Nota Kasir</title>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <center>
        <h4>Toko Arfah</h4>
    </center>
    <p>
        Tanggal: {{ $penjualan->created_at->format('d-m-Y H:i') }}<br>
        Kasir: {{ $penjualan->user->name ?? '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                <tr>
                    <td>{{ $item->produk->name }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <p>
        Total: Rp {{ number_format($penjualan->total) }}<br>
        Diskon: {{ $penjualan->diskon }} %<br>
        Bayar: Rp {{ number_format($penjualan->bayar) }}<br>
        Kembali: Rp
        {{ number_format($penjualan->bayar - ($penjualan->total - ($penjualan->total * $penjualan->diskon) / 100)) }}
    </p>
    <hr>
    <center>Terima kasih telah berbelanja!</center>

    <script>
        window.print();
    </script>
</body>

</html>
