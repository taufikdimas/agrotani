<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center">
            <span class="app-brand-logo demo">
                <img src="{{ asset('logo.png') }}" alt="Logo Perusahaan" style="width: 40px">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Agrotani</span>
        </a>
    
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none"></i>
        </a>
    </div>


  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-smile"></i>
        <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
        <span class="badge rounded-pill bg-danger ms-auto"></span>
      </a>
    </li>

    <!-- Inventory -->
    <li class="menu-item {{ request()->is('produk*') || request()->is('stok*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-box"></i>
        <div>Inventory</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('produk*') ? 'active' : '' }}">
          <a href="{{ url('/produk') }}" class="menu-link">
            <div>Produk</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('stok*') ? 'active' : '' }}">
          <a href="{{ url('/stok') }}" class="menu-link">
            <div>Stok Barang</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Customer -->
    <li class="menu-item {{ request()->is('customer*') ? 'active' : '' }}">
      <a href="{{ url('/customer') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div>Customer</div>
      </a>
    </li>

    <!-- User -->
    <li class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
      <a href="{{ url('/user') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Data User</div>
      </a>
    </li>

    <!-- Marketing -->
    <li class="menu-item {{ request()->is('marketing*') || request()->is('marketing-reports*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-badge-check"></i>
        <div>Marketing</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('marketing*') ? 'active' : '' }}">
          <a href="{{ url('/marketing') }}" class="menu-link">
            <div>Data Marketing</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('marketing-report*') ? 'active' : '' }}">
          <a href="{{ url('/marketing-report') }}" class="menu-link">
            <div>Laporan Marketing</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Penjualan -->
    <li class="menu-item {{ request()->is('penjualan*') ? 'active' : '' }}">
      <a href="{{ url('/penjualan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cart"></i>
        <div>Penjualan</div>
      </a>
    </li>

    <!-- Hutang & Piutang -->
    <li class="menu-item {{ request()->is('hutang*') || request()->is('piutang*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-wallet"></i>
        <div>Hutang & Piutang</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->is('hutang/hutang-customer*') ? 'active' : '' }}">
          <a href="{{ url('/hutang/hutang-customer') }}" class="menu-link">
            <div>Hutang Customer</div>
          </a>
        </li>
        <li class="menu-item {{ request()->is('piutang*') ? 'active' : '' }}">
          <a href="{{ url('/piutang') }}" class="menu-link">
            <div>Piutang</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Pengaturan Sistem -->
    <li class="menu-item {{ request()->is('settings*') ? 'active' : '' }}">
      <a href="{{ url('/settings') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div>Pengaturan Sistem</div>
      </a>
    </li>

    <!-- User -->
    <li class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
      <a href="{{ url('/user') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Data Pengguna</div>
      </a>
    </li>
    <!-- Logout -->
    <li class="menu-item">
      <a href="#" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div>Logout</div>
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>

  </ul>
</aside>
