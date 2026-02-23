@extends('home.app')

@section('title', 'Produk Diskon - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">🔥 Produk Diskon</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Produk Diskon</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="shop-page section">
      <div class="container" data-aos="fade-up">
        <!-- Stats row -->
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <div class="bg-danger text-white rounded-3 p-3 text-center">
              <h3>{{ $discountStats['total_discount_products'] }}</h3>
              <p class="mb-0">Produk Diskon</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="bg-warning text-dark rounded-3 p-3 text-center">
              <h3>{{ round($discountStats['max_discount_percentage']) }}%</h3>
              <p class="mb-0">Diskon Terbesar</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="bg-success text-white rounded-3 p-3 text-center">
              <h3>Rp {{ number_format($discountStats['total_savings'], 0, ',', '.') }}</h3>
              <p class="mb-0">Total Penghematan</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 mb-4">
            <div class="shop-sidebar">
              <div class="filter-widget mb-4">
                <h5>Kategori</h5>
                <ul class="list-unstyled">
                  <li><a href="{{ route('discount.products') }}" class="text-decoration-none {{ !request('category') ? 'fw-bold text-success' : 'text-muted' }}">Semua</a></li>
                  @foreach($categories as $cat)
                    <li><a href="{{ route('discount.products') }}?category={{ $cat->id }}" 
                           class="text-decoration-none {{ request('category') == $cat->id ? 'fw-bold text-success' : 'text-muted' }}">
                      {{ $cat->name }}
                    </a></li>
                  @endforeach
                </ul>
              </div>
              <form method="GET" class="filter-widget">
                <h5>Urutkan</h5>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                  <option value="discount_high" {{ request('sort') == 'discount_high' ? 'selected' : '' }}>Diskon Terbesar</option>
                  <option value="savings_high" {{ request('sort') == 'savings_high' ? 'selected' : '' }}>Penghematan Terbesar</option>
                  <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                  <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
                <input type="hidden" name="category" value="{{ request('category') }}">
              </form>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <p class="text-muted mb-0">{{ $products->total() }} produk diskon ditemukan</p>
            </div>
            @if($products->isEmpty())
              <div class="text-center py-5">
                <i class="bi bi-tag fs-1 text-muted"></i>
                <h5 class="mt-3">Tidak ada produk diskon saat ini</h5>
                <a href="{{ route('products') }}" class="btn btn-primary mt-2">Lihat Semua Produk</a>
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
