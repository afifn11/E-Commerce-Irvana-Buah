@extends('home.app')

@section('title', $product->name . ' - Irvana Buah')
@section('meta_description', Str::limit(strip_tags($product->description), 160))

@section('body_class', 'product-details-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">{{ $product->name }}</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('products') }}">Toko</a></li>
            @if($product->category)
              <li><a href="{{ route('products.by.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="current">{{ $product->name }}</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Product Details Section -->
    <section id="product-details" class="product-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="row">
          <!-- Product Images -->
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
            <div class="product-images position-relative">
              @if($product->is_new)
                <span class="badge bg-success position-absolute top-0 start-0 m-3" style="z-index:2">Baru</span>
              @endif
              @if($product->has_discount)
                <span class="badge bg-danger position-absolute top-0 end-0 m-3" style="z-index:2">-{{ $product->discount_percentage }}%</span>
              @endif
              <div class="main-image-container mb-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     id="main-product-image"
                     onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'"
                     style="width:100%;height:420px;object-fit:cover;border-radius:20px;box-shadow:0 8px 32px rgba(0,0,0,0.12);display:block;">
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="product-info">
              <div class="product-meta mb-2">
                @if($product->category)
                  <a href="{{ route('products.by.category', $product->category->slug) }}" class="product-category">
                    {{ $product->category->name }}
                  </a>
                @endif
                <div class="product-badges ms-2">
                  @if($product->is_featured)
                    <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Unggulan</span>
                  @endif
                  @if($product->stock_status === 'low_stock')
                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>Stok Terbatas</span>
                  @elseif($product->stock_status === 'out_of_stock')
                    <span class="badge bg-danger">Stok Habis</span>
                  @else
                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Tersedia</span>
                  @endif
                </div>
              </div>

              <h1 class="product-title">{{ $product->name }}</h1>

              <div class="product-price-container mb-4">
                @if($product->has_discount)
                  <span class="current-price">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                  <span class="original-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                  <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                  <div class="text-success small mt-1">
                    <i class="bi bi-piggy-bank me-1"></i>
                    Hemat Rp {{ number_format($product->price - $product->discount_price, 0, ',', '.') }}
                  </div>
                @else
                  <span class="current-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
                <span class="text-muted small ms-2">/kg</span>
              </div>

              @if($product->description)
              <div class="product-description mb-4">
                <p>{{ $product->description }}</p>
              </div>
              @endif

              <!-- Stock Info -->
              <div class="product-stock mb-3">
                <span class="text-muted"><i class="bi bi-box-seam me-1"></i>Stok: 
                  <strong class="{{ $product->is_low_stock ? 'text-warning' : 'text-success' }}">
                    {{ $product->stock }} kg tersedia
                  </strong>
                </span>
              </div>

              @if($product->stock > 0)
              <!-- Add to Cart -->
              <div class="product-actions">
                <div class="quantity-selector d-flex align-items-center mb-3">
                  <label class="me-2 fw-semibold">Jumlah:</label>
                  <button type="button" class="qty-btn minus" onclick="changeQty(-1)">−</button>
                  <input type="number" id="product-quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input text-center">
                  <button type="button" class="qty-btn plus" onclick="changeQty(1)">+</button>
                  <span class="ms-2 text-muted small">kg</span>
                </div>

                @auth
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <button type="button" class="btn btn-success btn-lg px-4 rounded-pill" id="addToCartBtn"
                            data-product-id="{{ $product->id }}" style="min-width:200px">
                      <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                      <i class="bi bi-cart3 me-1"></i>Keranjang
                    </a>
                  </div>
                @else
                  <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5 rounded-pill">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                  </a>
                @endauth

                <div id="cart-message" class="mt-2"></div>
              </div>
              @else
                <div class="alert alert-warning">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  Stok sedang habis. Silakan cek lagi nanti atau hubungi kami.
                </div>
              @endif

              <!-- Features -->
              <div class="product-features mt-4 pt-3 border-top">
                <div class="row g-2">
                  <div class="col-6">
                    <div class="feature-item d-flex align-items-center">
                      <i class="bi bi-truck text-success me-2"></i>
                      <small>Pengiriman Cepat</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="feature-item d-flex align-items-center">
                      <i class="bi bi-shield-check text-success me-2"></i>
                      <small>Jaminan Segar</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="feature-item d-flex align-items-center">
                      <i class="bi bi-award text-success me-2"></i>
                      <small>Kualitas Premium</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="feature-item d-flex align-items-center">
                      <i class="bi bi-headset text-success me-2"></i>
                      <small>Layanan 24/7</small>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
        <div class="related-products mt-5 pt-4 border-top">
          <h3 class="mb-4">Produk Sejenis</h3>
          <div class="row g-3">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-4 col-6">
              <div class="product-card h-100">
                <div class="product-image-wrapper">
                  <a href="{{ route('product.detail', $related->slug) }}">
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="img-fluid"
                         onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
                  </a>
                  @if($related->has_discount)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ $related->discount_percentage }}%</span>
                  @endif
                </div>
                <div class="product-card-body p-3">
                  <h6><a href="{{ route('product.detail', $related->slug) }}" class="text-dark text-decoration-none">{{ $related->name }}</a></h6>
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      @if($related->has_discount)
                        <span class="fw-bold text-danger">Rp {{ number_format($related->discount_price, 0, ',', '.') }}</span>
                        <small class="text-muted text-decoration-line-through ms-1">Rp {{ number_format($related->price, 0, ',', '.') }}</small>
                      @else
                        <span class="fw-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                      @endif
                    </div>
                    @auth
                    <button class="btn btn-sm btn-success rounded-pill px-3 quick-add" data-id="{{ $related->id }}">
                      <i class="bi bi-cart-plus"></i>
                    </button>
                    @endauth
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

      </div>
    </section>

</main>
@endsection

@section('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('product-quantity');
    const max = parseInt(input.max);
    let val = parseInt(input.value) + delta;
    if(val < 1) val = 1;
    if(val > max) val = max;
    input.value = val;
}

@auth
document.getElementById('addToCartBtn')?.addEventListener('click', function() {
    const productId = this.dataset.productId;
    const quantity = document.getElementById('product-quantity').value;
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass me-2"></i>Menambahkan...';

    fetch('{{ route("cart.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: parseInt(quantity) })
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('cart-message');
        if(data.success) {
            msg.innerHTML = '<div class="alert alert-success py-2 rounded-3"><i class="bi bi-check-circle me-1"></i>' + data.message + '</div>';
            document.getElementById('cart-badge').textContent = data.cart_count;
            btn.innerHTML = '<i class="bi bi-cart-check me-2"></i>Ditambahkan!';
            btn.classList.add('btn-outline-success');
            btn.classList.remove('btn-success');
            setTimeout(() => {
                btn.disabled = false;
                btn.classList.remove('btn-outline-success');
                btn.classList.add('btn-success');
                btn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang';
                msg.innerHTML = '';
            }, 2500);
        } else {
            msg.innerHTML = '<div class="alert alert-danger py-2 rounded-3"><i class="bi bi-x-circle me-1"></i>' + data.message + '</div>';
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang';
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang';
    });
});

// Quick add for related products
document.querySelectorAll('.quick-add').forEach(btn => {
    btn.addEventListener('click', function() {
        fetch('{{ route("cart.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ product_id: this.dataset.id, quantity: 1 })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                document.getElementById('cart-badge').textContent = data.cart_count;
                this.innerHTML = '<i class="bi bi-check"></i>';
                setTimeout(() => this.innerHTML = '<i class="bi bi-cart-plus"></i>', 1500);
            }
        });
    });
});
@endauth
</script>
@endsection
