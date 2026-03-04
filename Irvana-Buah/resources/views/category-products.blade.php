@extends('home.app')

@section('title', $category->name . ' - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">{{ $category->name }}</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('products') }}">Toko</a></li>
            <li class="current">{{ $category->name }}</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="shop-page section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <!-- Sidebar -->
          <div class="col-lg-3 sidebar mb-4">
            <button id="sidebar-toggle-btn" class="sidebar-toggle-btn d-md-none">
                <span><i class="bi bi-funnel me-2"></i>Filter & Kategori</span>
                <i class="toggle-icon bi bi-chevron-down"></i>
              </button>
              <div id="sidebar-collapsible" class="sidebar-collapsible">
              <div class="widgets-container">
              <!-- Widget Kategori -->
              <div class="product-categories-widget widget-item">
                <h3 class="widget-title">Kategori Buah</h3>
                <ul class="category-tree list-unstyled mb-0">
                  <li class="category-item">
                    <a href="{{ route('products') }}" class="category-link text-muted">Semua Produk</a>
                  </li>
                  @foreach($categories as $cat)
                    <li class="category-item">
                      <div class="d-flex justify-content-between align-items-center category-header">
                        <a href="{{ route('products.by.category', $cat->slug) }}"
                           class="category-link {{ $cat->id == $category->id ? 'fw-bold text-success' : '' }}">
                          {{ $cat->name }}
                        </a>
                        @if(isset($cat->products_count) && $cat->products_count > 0)
                          <span class="badge bg-primary rounded-pill ms-2">{{ $cat->products_count }}</span>
                        @endif
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>

              <!-- Widget Urutkan -->
              <div class="pricing-range-widget widget-item">
                <h3 class="widget-title">Urutkan</h3>
                <form method="GET">
                  <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                  </select>
                  <input type="hidden" name="search" value="{{ request('search') }}">
                </form>
              </div>
            </div><!-- end widgets-container -->
            </div><!-- end sidebar-collapsible -->
          </div><!-- end col-lg-3 sidebar -->
          <!-- Products -->
          <div class="col-lg-9 order-2 order-lg-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <p class="text-muted mb-0">{{ $products->total() }} produk ditemukan</p>
              <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari di kategori ini..." value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <button type="submit" class="btn btn-irvana btn-sm">Cari</button>
              </form>
            </div>
            @if($products->isEmpty())
              <div class="text-center py-5">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h5 class="mt-3">Tidak ada produk ditemukan</h5>
                <a href="{{ route('products.by.category', $category->slug) }}" class="btn btn-irvana mt-2">Reset Filter</a>
              </div>
            @else
              <div class="row g-3 gy-4">
                @foreach($products as $product)
                  @include('home.partials.product-card', ['product' => $product, 'colClass' => 'col-6 col-sm-6 col-lg-4'])
                @endforeach
              </div>
              @if($products->hasPages())
              <section class="category-pagination section">
                <div class="container">
                  {{ $products->links() }}
                </div>
              </section>
              @endif
            @endif
          </div>
        </div>
      </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const collapsible = document.getElementById('sidebar-collapsible');
    if (toggleBtn && collapsible) {
        toggleBtn.addEventListener('click', function() {
            const isOpen = collapsible.classList.toggle('open');
            toggleBtn.querySelector('.toggle-icon').className = 'toggle-icon bi bi-chevron-' + (isOpen ? 'up' : 'down');
        });
    }
});
</script>
@endsection
