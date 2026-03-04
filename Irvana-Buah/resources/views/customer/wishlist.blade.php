@extends('home.app')
@section('title', 'Wishlist Saya - Irvana Buah')

@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Wishlist Saya</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li class="current">Wishlist</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="section">
    <div class="container" data-aos="fade-up">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($items->isEmpty())
        <div class="text-center py-5">
          <div style="font-size:4rem;margin-bottom:1rem;">🤍</div>
          <h4 style="color:#555;">Wishlist Anda masih kosong</h4>
          <p class="text-muted mb-4">Simpan produk favorit Anda untuk dibeli nanti</p>
          <a href="{{ route('products') }}" class="btn-irvana btn-irvana-lg">
            <i class="bi bi-bag me-2"></i>Mulai Belanja
          </a>
        </div>
      @else
        <div class="d-flex justify-content-between align-items-center mb-4">
          <p class="text-muted mb-0">{{ $items->count() }} produk tersimpan</p>
          <a href="{{ route('products') }}" class="btn-irvana-outline">
            <i class="bi bi-plus me-1"></i>Tambah Produk
          </a>
        </div>

        <div class="row g-3 gy-4">
          @foreach($items as $item)
            @if($item->product)
              @include('home.partials.product-card', [
                'product'  => $item->product,
                'colClass' => 'col-6 col-sm-6 col-lg-3',
              ])
            @endif
          @endforeach
        </div>
      @endif
    </div>
  </section>
</main>
@endsection
