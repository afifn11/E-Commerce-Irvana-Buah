<header id="header" class="header position-relative">

    <div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">

          <a href="{{ url('/') }}" class="logo d-flex align-items-center">
            {{-- <img src="{{ asset('assets/img/logo.webp') }}" alt=""> --}}
            <h1 class="sitename">Irvana Buah</h1>
          </a>

          <form class="search-form desktop-search-form">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for products">
              <button class="btn" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
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
                  <h6>Welcome to <span class="sitename">eStore</span></h6>
                  <p class="mb-0">Access account &amp; manage orders</p>
                </div>
                <div class="dropdown-body">
                  <a class="dropdown-item d-flex align-items-center" href="{{ url('/account') }}">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>My Profile</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="{{ url('/account') }}">
                    <i class="bi bi-bag-check me-2"></i>
                    <span>My Orders</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="{{ url('/account') }}">
                    <i class="bi bi-heart me-2"></i>
                    <span>My Wishlist</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="{{ url('/account') }}">
                    <i class="bi bi-gear me-2"></i>
                    <span>Settings</span>
                  </a>
                </div>
                <div class="dropdown-footer">
                  <a href="{{ url('/login') }}" class="btn btn-primary w-100 mb-2">Sign In</a>
                  <a href="{{ url('/register') }}" class="btn btn-outline-primary w-100">Register</a>
                </div>
              </div>
            </div>

            <a href="{{ url('/account') }}" class="header-action-btn d-none d-md-block">
              <i class="bi bi-heart"></i>
              <span class="badge">0</span>
            </a>

            <a href="{{ url('/cart') }}" class="header-action-btn">
              <i class="bi bi-cart3"></i>
              <span class="badge">3</span>
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
              <li><a href="{{ url('/') }}" class="active">Home</a></li>
              <li><a href="{{ url('/about') }}">About</a></li>
              <li><a href="{{ url('/category') }}">Category</a></li>
              <li><a href="{{ url('/product-details') }}">Product Details</a></li>
              <li><a href="{{ url('/cart') }}">Cart</a></li>
              <li><a href="{{ url('/checkout') }}">Checkout</a></li>  
              <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <div class="collapse" id="mobileSearch">
      <div class="container">
        <form class="search-form">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for products">
            <button class="btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
</header>