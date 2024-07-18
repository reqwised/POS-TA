<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-primary">
        <img src="{{ url($setting->path_logo) }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $setting->nama_perusahaan }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{(Route::is('dashboard')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if (auth()->user()->role == 'Pemilik Toko')

                <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="{{ route('kategori.index') }}" class="nav-link {{(Route::is('kategori.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Kategori
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link {{(Route::is('produk.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('member.index') }}" class="nav-link {{(Route::is('member.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Member
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link {{(Route::is('supplier.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>

                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="{{ route('pengeluaran.index') }}" class="nav-link {{(Route::is('pengeluaran.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Pengeluaran
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pembelian.index') }}" class="nav-link {{(Route::is('pembelian.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-download"></i>
                        <p>
                            Pembelian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{(Route::is('penjualan.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jual.index') }}" class="nav-link {{(Route::is('jual.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Transaksi
                        </p>
                    </a>
                </li>

                <li class="nav-header">REPORT</li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{(Route::is('laporan.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('terlaris.index') }}" class="nav-link {{(Route::is('terlaris.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Laporan Barang
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('laporan.labarugi') }}" class="nav-link {{(Route::is('laporan.labarugi')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Laporan Omset dan Pendapatan
                        </p>
                    </a>
                </li>

                <li class="nav-header">SYSTEM</li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{(Route::is('user.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link {{(Route::is('setting.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                        </p>
                    </a>
                </li>

                @elseif (auth()->user()->role == 'Kasir')

                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{(Route::is('penjualan.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>
                            Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jual.index') }}" class="nav-link {{(Route::is('jual.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Transaksi
                        </p>
                    </a>
                </li>

                @else

                <li class="nav-item">
                    <a href="{{ route('kategori.index') }}" class="nav-link {{(Route::is('kategori.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>
                            Kategori
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link {{(Route::is('produk.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link {{(Route::is('supplier.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pembelian.index') }}" class="nav-link {{(Route::is('pembelian.index')) ? 'nav-link active' : '' }}">
                        <i class="nav-icon fas fa-download"></i>
                        <p>
                            Pembelian
                        </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>