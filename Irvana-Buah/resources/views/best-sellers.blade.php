@extends('home.app')

@section('title', 'Best Seller - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">⭐ Produk Terlaris</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Best Seller</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="shop-page section">
      <div class="container" data-aos="fade-up">
        <div class="row irvana-shop-row">
          <div class="col-lg-3 sidebar mb-4 order-1 order-lg-0">
            <button id="sidebar-toggle-btn" class="sidebar-toggle-btn d-md-none">
                <span><i class="bi bi-funnel me-2"></i>Filter & Kategori</span>
                <i class="toggle-icon bi bi-chevron-down"></i>
              </button>
              <div id="sidebar-collapsible" class="sidebar-collapsible">
              <div class="widgets-container">
              <div class="product-categories-widget widget-item">
                <h3 class="widget-title">Kategori Buah</h3>
                <ul class="category-tree list-unstyled mb-0">
                  <li class="category-item">
                    <a href="{{ route('best-sellers') }}"
                       class="category-link {{ !request('category') ? 'fw-bold text-success' : '' }}">
                      Semua
                    </a>
                  </li>
                  @foreach($categories as $cat)
                    <li class="category-item">
                      <div class="d-flex justify-content-between align-items-center category-header">
                        <a href="{{ route('best-sellers') }}?category={{ $cat->id }}"
                           class="category-link {{ request('category') == $cat->id ? 'fw-bold text-success' : '' }}">
                          {{ $cat->name }}
                        </a>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
              </div><!-- end sidebar-collapsible -->
          </div>
          <div class="col-lg-9 order-2 order-lg-1">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
              <p class="text-muted mb-0">{{ $products->total() }} produk terlaris ditemukan</p>
              <form method="GET" class="d-flex gap-2 align-items-center">
                <select name="sort" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                  <option value="best_selling" {{ request('sort','best_selling') == 'best_selling' ? 'selected' : '' }}>Terlaris</option>
                  <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                  <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                  <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                </select>
                <input type="hidden" name="category" value="{{ request('category') }}">
              </form>
            </div>
            @if($products->isEmpty())
              <div class="text-center py-5">
                <i class="bi bi-award fs-1 text-muted"></i>
                <h5 class="mt-3">Belum ada produk terlaris</h5>
                <a href="{{ route('products') }}" class="btn btn-irvana mt-2">Lihat Semua Produk</a>
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
