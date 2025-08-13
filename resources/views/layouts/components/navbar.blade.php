<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item  ">
                <a href="{{ route('dashboard.index') }}" class='menu-link'>
                    <span><i class="bi bi-speedometer2"></i> Dashboard</span>
                </a>
            </li>

            <li class="menu-item  ">
                <a href="index.html" class='menu-link'>
                    <span><i class="bi bi-people"></i> Pengguna</span>
                </a>
            </li>

            <li class="menu-item  ">
                <a href="{{ route('daftar.barang.index') }}" class='menu-link'>
                    <span><i class="bi box-seam"></i> Daftar Barang</span>
                </a>
            </li>

            <li class="menu-item active has-sub">
                <a href="" class='menu-link'>
                    <span><i class="bi bi-cart-plus"></i> Pembelian</span>
                </a>
                <div class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item  ">
                                <a href="{{ route('daftar-vendor.index') }}" class='submenu-link'>Daftar Vendor</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="{{ route('stock-opname.index') }}" class='submenu-link'>
                                    Stock Opname
                                </a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="{{ route('hutang.index') }}" class='submenu-link'>Hutang</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Retur/Pengembalian</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li class="menu-item active has-sub">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-cart-check"></i> Penjualan</span>
                </a>
                <div class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Faktur/Tagihan</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Bayar Tagihan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li class="menu-item active has-sub">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-file-earmark-bar-graph"></i> Keuangan</span>
                </a>
                <div class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Akun Bank</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li class="menu-item active has-sub">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-plus-square-fill"></i> Laporan</span>
                </a>
                <div class="submenu ">
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Stock Opname</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Pembelian</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="layout-default.html" class='submenu-link'>Penjualan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
