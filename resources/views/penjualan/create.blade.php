<form action="{{ route('penjualan.store') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody id="produk-list">
            <tr>
                <td>
                    <select name="produk_id[]">
                        @foreach ($produk as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} - Rp{{ number_format($item->harga) }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="jumlah[]" min="1" value="1"></td>
            </tr>
        </tbody>
    </table>
    <button type="submit">Simpan</button>
</form>
