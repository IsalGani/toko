<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">📦 Semua Produk</h3>
    </div>
    <div class="box-body">
        <form method="GET" action="{{ route('products.index') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label for="kategori" class="mr-2">Kategori:</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua</option>
                    @foreach ($categories as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mx-3">
                <label for="search" class="mr-2">Cari:</label>
                <input type="text" name="search" class="form-control" placeholder="Nama produk..."
                    value="{{ request('search') }}">
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
        </form>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="box box-widget text-center" style="min-height: 300px;">
                        <div class="box-body">
                            {{-- Nama produk --}}
                            <h4 class="text-bold">{{ $product->name }}</h4>

                            {{-- Kategori --}}
                            <span
                                class="label label-info">{{ $product->category->nama_category ?? 'Tanpa Kategori' }}</span>

                            {{-- Harga dan Diskon --}}
                            <p class="mt-2">
                                @if ($product->discount ?? 0 > 0)
                                    <span class="badge bg-danger">Promo</span>
                                    <del
                                        class="text-muted">Rp{{ number_format($product->price, 0, ',', '.') }}</del><br>
                                    <strong class="text-danger">Diskon
                                        Rp{{ number_format($product->discount, 0, ',', '.') }}</strong><br>
                                    <span class="text-success h4">
                                        Rp{{ number_format($product->price - $product->discount, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span
                                        class="text-primary h4">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                @endif
                            </p>

                            {{-- Stok --}}
                            <p class="text-muted">Stok: {{ $product->stock }}</p>

                            {{-- Tombol beli hanya untuk pelanggan --}}
                            @if (auth()->user()->level == 0)
                                <form action="{{ route('keranjang.tambah') }}" method="POST" class="form-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="qty" value="1" min="1"
                                        max="{{ $product->stock }}" class="form-control input-sm" style="width: 60px;"
                                        required>
                                    <button class="btn btn-success btn-sm mt-2" type="submit">
                                        <i class="fa fa-cart-plus"></i> Beli
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p class="text-muted">Belum ada produk tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
