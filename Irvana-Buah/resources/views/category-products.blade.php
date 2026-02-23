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
          <div class="col-lg-3 mb-4">
            <div class="shop-sidebar">
              <div class="filter-widget mb-4">
                <h5>Filter Kategori</h5>
                <ul class="list-unstyled">
                  <li><a href="{{ route('products') }}" class="text-decoration-none text-muted">Semua Produk</a></li>
                  @foreach($categories as $cat)
                    <li><a href="{{ route('products.by.category', $cat->slug) }}" 
                           class="text-decoration-none {{ $cat->id == $category->id ? 'fw-bold text-success' : 'text-muted' }}">
                      {{ $cat->name }}
                    </a></li>
                  @endforeach
                </ul>
              </div>
              <form method="GET" class="filter-widget">
                <h5>Urutkan</h5>
                <select name="sort" class="form-select mb-2" onchange="this.form.submit()">
                  <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                  <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                  <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                  <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                </select>
                <input type="hidden" name="search" value="{{ request('search') }}">
              </form>
            </div>
          </div>
          <!-- Products -->
          <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <p class="text-muted mb-0">{{ $products->total() }} produk ditemukan</p>
              <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari di kategori ini..." value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <button type="submit" class="btn btn-sm btn-primary">Cari</button>
              </form>
            </div>
            @if($products->isEmpty())
              <div class="text-center py-5">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h5 class="mt-3">Tidak ada produk ditemukan</h5>
                <a href="{{ route('products.by.category', $category->slug) }}" class="btn btn-primary mt-2">Reset Filter</a>
              </div>
            @else
              <div class="row g-3">
                @foreach($products as $product)
                  @include('home.partials.product-card', ['product' => $product])
                @endforeach
              </div>
              <div class="mt-4">{{ $products->links() }}</div>
            @endif
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
