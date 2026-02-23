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
        <div class="row">
          <div class="col-lg-3 mb-4">
            <div class="shop-sidebar">
              <div class="filter-widget mb-4">
                <h5>Kategori</h5>
                <ul class="list-unstyled">
                  <li><a href="{{ route('best-sellers') }}" class="text-decoration-none {{ !request('category') ? 'fw-bold text-success' : 'text-muted' }}">Semua</a></li>
                  @foreach($categories as $cat)
                    <li><a href="{{ route('best-sellers') }}?category={{ $cat->id }}" 
                           class="text-decoration-none {{ request('category') == $cat->id ? 'fw-bold text-success' : 'text-muted' }}">
                      {{ $cat->name }}
                    </a></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            @if($products->isEmpty())
              <div class="text-center py-5">
                <i class="bi bi-award fs-1 text-muted"></i>
                <h5 class="mt-3">Belum ada produk terlaris</h5>
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
