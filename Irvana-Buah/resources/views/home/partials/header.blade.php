<header id="header" class="header position-relative">

    <div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">

          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <h1 class="sitename">Irvana Buah</h1>
          </a>

          <form class="search-form desktop-search-form" action="{{ route('products') }}" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Cari buah segar..." value="{{ request('search') }}" autocomplete="off" id="headerSearchInput">
              <button class="btn" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
            <div id="searchSuggestions" class="search-suggestions" style="display:none;"></div>
          </form>

          <div class="header-actions d-flex align-items-center justify-content-end">

            <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
              <i class="bi bi-search"></i>
            </button>

            <div class="dropdown account-dropdown">
              <button class="header-action-btn" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
              </button>
              <div class="dropdown-menu">
                <div class="dropdown-header">
                  <h6>Selamat Datang di <span class="sitename">Irvana Buah</span></h6>
                  @auth
                    <p class="mb-0">Halo, <strong>{{ Auth::user()->name }}</strong></p>
                  @else
                    <p class="mb-0">Masuk untuk mengelola pesanan Anda</p>
                  @endauth
                </div>
                <div class="dropdown-body">
                  @auth
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('customer.profile') }}">
                      <i class="bi bi-person-circle me-2"></i>
                      <span>Profil Saya</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('customer.orders') }}">
                      <i class="bi bi-bag-check me-2"></i>
                      <span>Pesanan Saya</span>
                    </a>
                    @if(Auth::user()->role === 'admin')
                      <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>Dashboard Admin</span>
                      </a>
                    @endif
                  @else
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                      <i class="bi bi-box-arrow-in-right me-2"></i>
                      <span>Masuk</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('register') }}">
                      <i class="bi bi-person-plus me-2"></i>
                      <span>Daftar</span>
                    </a>
                  @endauth
                </div>
                @auth
                  <div class="dropdown-footer">
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                      </button>
                    </form>
                  </div>
                @endauth
              </div>
            </div>

            <a href="{{ route('cart.index') }}" class="header-action-btn position-relative" id="cartHeaderBtn">
              <i class="bi bi-cart3"></i>
              @auth
                @php
                  $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                @endphp
                <span class="badge" id="cart-badge">{{ $cartCount }}</span>
              @else
                <span class="badge" id="cart-badge">0</span>
              @endauth
            </a>

            <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>

          </div>
        </div>
      </div>
    </div>

    <div class="header-nav">
      <div class="container-fluid container-xl">
        <div class="position-relative">
          <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class=active' : '' }}>Home</a></li>
              <li><a href="{{ route('about') }}" {{ request()->routeIs('about') ? 'class=active' : '' }}>Tentang Kami</a></li>
              <li class="dropdown">
                <a href="{{ route('products') }}" {{ request()->routeIs('products') ? 'class=active' : '' }}>
                  <span>Toko</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                  <li><a href="{{ route('products') }}">Semua Produk</a></li>
                  <li><a href="{{ route('discount.products') }}">Produk Diskon</a></li>
                  <li><a href="{{ route('best-sellers') }}">Best Seller</a></li>
                </ul>
              </li>
              <li><a href="{{ route('cart.index') }}" {{ request()->routeIs('cart.index') ? 'class=active' : '' }}>Keranjang</a></li>
              <li><a href="{{ route('contact') }}" {{ request()->routeIs('contact') ? 'class=active' : '' }}>Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
          </nav>
        </div>
      </div>
    </div>

    <div class="collapse" id="mobileSearch">
      <div class="container">
        <form class="search-form" action="{{ route('products') }}" method="GET">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari buah segar...">
            <button class="btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
</header>
