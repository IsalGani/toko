<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li>
                @if (auth()->user()->level == 0)
                    <span class="">Selamat Datang {{ auth()->user()->name }}</span>
                @else
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                @endif
            </li>


            {{-- Sidebar untuk Admin (level 1) --}}
            @if (auth()->user()->level == 1)
                <li class="header">MASTER</li>
                <li><a href="{{ route('product.index') }}"><i class="fa fa-cubes"></i> <span>Produk</span></a></li>
                <li><a href="{{ route('category.index') }}"><i class="fa fa-tags"></i> <span>Kategori</span></a></li>
                <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Manajemen User</span></a></li>

                <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Manajemen User</span></a>
                </li>
                <li class="header">TRANSAKSI</li>
                <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-file-text"></i> <span>Riwayat
                            Penjualan</span></a></li>
                <li><a href="{{ route('transaksi.baru') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi
                            Baru</span></a></li>
                <li class="header">LAPORAN</li>
                <li><a href="{{ route('laporan.index') }}"><i class="fa fa-file-pdf-o"></i> <span>Laporan
                            Penjualan</span></a></li>
                <li class="header">STOK</li>
                <li><a href="{{ route('stok.index') }}"><i class="fa fa-archive"></i> <span>Stok Produk</span></a></li>
                <li class="header">PENGATURAN</li>
                <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>User</span></a></li>
                <li><a href="{{ route('setting.index') }}"><i class="fa fa-cogs"></i> <span>Pengaturan Toko</span></a>
                </li>
            @endif
            {{-- Sidebar untuk Kasir (level 2) --}}
            @if (auth()->user()->level == 2)
                <li class="header">MANAJEMEN TOKO</li>
                <li><a href="{{ route('category.index') }}"><i class="fa fa-tags"></i> <span>Kategori</span></a>
                </li>
                <li><a href="{{ route('products.index') }}"><i class="fa fa-cube"></i> <span>Produk</span></a>
                </li>
                <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Manajemen
                            Pelanggan</span></a></li>


                <li class="header">TRANSAKSI</li>
                <li>
                    <a href="{{ route('transaksi.baru') }}">
                        <i class="fa fa-cart-plus"></i> <span>Transaksi Baru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjualan.index') }}">
                        <i class="fa fa-file-text"></i> <span>Riwayat Penjualan</span>
                    </a>
                </li>
            @endif


            {{-- Sidebar untuk Pelanggan (level 0) --}}
            @if (auth()->user()->level == 0)
                <li class="header">TOKO</li>
                <li>
                    <a href="{{ route('product.index') }}">
                        <i class="fa fa-tags"></i> <span>Produk dan Promo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keranjang.index') }}">
                        <i class="fa fa-shopping-cart"></i> <span>Keranjang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('checkout.riwayat') }}">
                        <i class="fa fa-list"></i> <span>Riwayat Pesanan</span>
                    </a>
                </li>
            @endif



            {{-- Sidebar untuk semua user --}}
            <li class="header">AKUN</li>
            <li><a href="{{ route('user.profil') }}"><i class="fa fa-user"></i> <span>Profil</span></a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
                </form>
            </li>
        </ul>
    </section>
</aside>
