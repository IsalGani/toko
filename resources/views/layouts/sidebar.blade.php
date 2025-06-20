<aside class="main-sidebar">
    <section class="sidebar">
        <!-- User Panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? 'adminlte/dist/img/user2-160x160.jpg') }}"
                    class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

            {{-- PEMILIK / ADMIN --}}
            @if (auth()->user()->level == 1)
                <li class="header">MENU ADMIN</li>
                <li><a href="{{ route('product.index') }}"><i class="fa fa-cubes"></i> <span>Kelola product</span></a>
                </li>
                <li><a href="#"><i class="fa fa-bar-chart"></i> <span>Laporan
                            Penjualan</span></a></li>
                <li><a href="{{ route('stok.index') }}"><i class="fa fa-archive"></i> <span>Stok Barang</span></a></li>

                {{-- KARYAWAN / KASIR --}}
            @elseif(auth()->user()->level == 2)
                <li class="header">MENU KASIR</li>
                <li><a href="#"><i class="fa fa-shopping-cart"></i> <span>Input
                            Transaksi</span></a></li>
                <li><a href="#"><i class="fa fa-users"></i> <span>Data Pelanggan</span></a>
                </li>
                <li><a href="#"><i class="fa fa-file-text-o"></i> <span>Laporan
                            Penjualan</span></a></li>

                {{-- PELANGGAN --}}
            @elseif(auth()->user()->level == 0)
                <li class="header">MENU PELANGGAN</li>
                <li><a href="{{ route('product.index') }}"><i class="fa fa-shopping-bag"></i> <span>Belanja
                            product</span></a></li>
                <li><a href="#"><i class="fa fa-tags"></i> <span>Lihat Promo</span></a></li>
                <li><a href="#"><i class="fa fa-cart-plus"></i> <span>Keranjang</span></a></li>
                <li><a href="#"><i class="fa fa-list"></i> <span>Pesanan Saya</span></a>
                </li>
            @endif

            <li class="header">AKUN</li>
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
