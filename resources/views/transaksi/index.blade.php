@extends('layouts.master')

@section('title')
    Transaksi Baru
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Produk</h3>
                </div>
                <div class="box-body">
                    <form class="form-produk">
                        @csrf
                        <div class="form-group">
                            <label for="product_code">Kode Produk</label>
                            <input type="text" id="product_code" class="form-control"
                                placeholder="Scan barcode atau masukkan kode">
                        </div>
                    </form>

                    <table class="table table-striped" id="table-keranjang">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Baris produk akan ditambahkan dengan JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <form action="{{ route('transaksi.simpan') }}" method="POST" class="form-transaksi">
                @csrf
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pembayaran</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Total</label>
                            <input type="text" name="total" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Diskon (%)</label>
                            <input type="number" name="diskon" class="form-control" value="0">
                        </div>
                        <div class="form-group">
                            <label>Diterima</label>
                            <input type="number" name="diterima" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kembali</label>
                            <input type="text" name="kembali" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-success btn-block" type="submit">Simpan Transaksi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
<script>
let keranjang = [];

function renderKeranjang() {
    const tbody = $('#table-keranjang tbody');
    tbody.empty();

    let total = 0;
    keranjang.forEach((item, index) => {
        const subtotal = item.harga * item.qty;
        total += subtotal;

        tbody.append(`
            <tr>
                <td>${item.nama}</td>
                <td>Rp ${item.harga.toLocaleString()}</td>
                <td>
                    <input type="number" class="form-control input-sm qty" data-index="${index}" value="${item.qty}" min="1">
                </td>
                <td>Rp ${subtotal.toLocaleString()}</td>
                <td><button type="button" class="btn btn-danger btn-sm btn-hapus" data-index="${index}"><i class="fa fa-trash"></i></button></td>
            </tr>
        `);
    });

    $('input[name=total]').val(total);
    hitungKembali();
}

function hitungKembali() {
    let total = parseInt($('input[name=total]').val()) || 0;
    let diskon = parseInt($('input[name=diskon]').val()) || 0;
    let diterima = parseInt($('input[name=diterima]').val()) || 0;

    let bayar = total - (total * diskon / 100);
    let kembali = diterima - bayar;

    $('input[name=kembali]').val(kembali > 0 ? kembali : 0);
}

$('#product_code').keypress(function (e) {
    if (e.which === 13) {
        e.preventDefault();
        let kode = $(this).val();

        if (!kode) return;

        $.get('/api/product/' + kode, function (data) {
            if (!data) return alert('Produk tidak ditemukan');

            let existing = keranjang.find(p => p.id === data.id);
            if (existing) {
                existing.qty++;
            } else {
                keranjang.push({
                    id: data.id,
                    nama: data.name,
                    harga: data.price,
                    qty: 1
                });
            }

            renderKeranjang();
            $('#product_code').val('').focus();
        });
    }
});

$(document).on('click', '.btn-hapus', function () {
    const index = $(this).data('index');
    keranjang.splice(index, 1);
    renderKeranjang();
});

$(document).on('change', '.qty', function () {
    const index = $(this).data('index');
    const qty = parseInt($(this).val());
    if (qty > 0) {
        keranjang[index].qty = qty;
        renderKeranjang();
    }
});

$('input[name=diskon], input[name=diterima]').on('input', hitungKembali);

$('.form-transaksi').on('submit', function (e) {
    e.preventDefault();

    if (keranjang.length === 0) return alert('Keranjang kosong');

    $.post("{{ route('transaksi.simpan') }}", {
        _token: '{{ csrf_token() }}',
        items: keranjang,
        total: $('input[name=total]').val(),
        diskon: $('input[name=diskon]').val(),
        diterima: $('input[name=diterima]').val()
    }, function (res) {
        alert('Transaksi berhasil disimpan!');
        window.location.href = "{{ route('transaksi.nota_besar') }}";
    }).fail(function () {
        alert('Gagal menyimpan transaksi!');
    });
});
</script>
@endpush

@endsection
