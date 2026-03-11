@extends('home.app')

@section('title', $product->name . ' - Irvana Buah')
@section('og_type',        'product')
@section('og_title',       $product->name . ' - Irvana Buah')
@section('og_description', Str::limit(strip_tags($product->description ?? ''), 200))
@section('og_image',       $product->image_url)
@section('meta_description', Str::limit(strip_tags($product->description), 160))

@section('body_class', 'product-details-page')

@section('styles')
<style>
/* ── Stock + Wishlist row ── */
.product-stock-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.stock-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: .88rem;
    color: #475569;
}
.wishlist-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 6px 16px;
    font-size: .88rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all .25s;
    white-space: nowrap;
}
.wishlist-pill-btn:hover,
.wishlist-pill-btn.active,
.wishlist-pill-btn.wishlisted {
    border-color: #f43f5e;
    color: #f43f5e;
    background: #fff1f4;
}

/* ── Beli Sekarang button ── */
.detail-buy-now-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 28px;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 12px;
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: #fff !important;
    border: none;
    cursor: pointer;
    min-width: 180px;
    box-shadow: 0 4px 14px rgba(249,115,22,.35);
    transition: all 0.3s ease;
    text-decoration: none;
}
.detail-buy-now-btn:hover {
    background: linear-gradient(135deg, #ea580c, #c2410c);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249,115,22,.45);
    color: #fff !important;
}
.detail-buy-now-btn:active  { transform: translateY(0); }
.detail-buy-now-btn:disabled { opacity: .7; cursor: not-allowed; transform: none; }

@media (max-width: 767px) {
    .detail-buy-now-btn { width: 100%; min-width: unset; }
    .product-stock-row  { gap: 8px; }
}
</style>
@endsection

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
                     class="detail-main-img" style="width:100%;height:420px;object-fit:cover;border-radius:20px;box-shadow:0 8px 32px rgba(0,0,0,0.12);display:block;">
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

              <!-- Stock Info + Wishlist -->
              <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                <span class="stock-badge-pill">
                  <i class="bi bi-box-seam me-1"></i>Stok:
                  <strong class="{{ $product->is_low_stock ? 'text-warning' : 'text-success' }}">
                    {{ $product->stock }} kg tersedia
                  </strong>
                </span>
                @auth
                <button type="button" class="wishlist-pill-btn detail-wishlist-btn"
                        data-wishlist-id="{{ $product->id }}">
                  <i class="bi bi-heart"></i>
                  <span>Simpan ke Wishlist</span>
                </button>
                @endauth
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
                  <div class="detail-btn-group">
                    <button type="button" class="detail-add-to-cart-btn" id="addToCartBtn"
                            data-product-id="{{ $product->id }}">
                      <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>
                    <button type="button" class="detail-buy-now-btn" id="buyNowBtn"
                            data-product-id="{{ $product->id }}">
                      <i class="bi bi-lightning-fill me-2"></i>Beli Sekarang
                    </button>
                  </div>
                @else
                  <a href="{{ route('login') }}" class="detail-add-to-cart-btn" style="text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">
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
          <div class="row g-3 gy-4">
            @foreach($relatedProducts as $related)
              @include('home.partials.product-card', ['product' => $related, 'colClass' => 'col-6 col-sm-6 col-lg-3'])
            @endforeach
          </div>
        </div>
        @endif

      </div>
    </section>

    {{-- Ulasan Pelanggan --}}
    <section class="section pt-0">
      <div class="container" data-aos="fade-up">
        @include('home.partials.product-reviews')
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
            btn.style.background = "#38a169";
            
            setTimeout(() => {
                btn.disabled = false;
                
                
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

// Beli Sekarang — add to cart then redirect to checkout
document.getElementById('buyNowBtn')?.addEventListener('click', function() {
    const productId = this.dataset.productId;
    const quantity  = document.getElementById('product-quantity').value;
    const btn       = this;
    btn.disabled    = true;
    btn.innerHTML   = '<i class="bi bi-hourglass me-2"></i>Memproses...';

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
        if(data.success) {
            document.getElementById('cart-badge').textContent = data.cart_count;
            btn.innerHTML = '<i class="bi bi-check me-2"></i>Mengarahkan...';
            window.location.href = '{{ url("/cart/checkout") }}';
        } else {
            const msg = document.getElementById('cart-message');
            msg.innerHTML = '<div class="alert alert-danger py-2 rounded-3"><i class="bi bi-x-circle me-1"></i>' + data.message + '</div>';
            btn.disabled  = false;
            btn.innerHTML = '<i class="bi bi-lightning-fill me-2"></i>Beli Sekarang';
            setTimeout(() => msg.innerHTML = '', 3000);
        }
    })
    .catch(() => {
        btn.disabled  = false;
        btn.innerHTML = '<i class="bi bi-lightning-fill me-2"></i>Beli Sekarang';
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
{{-- Reviews Section --}}
@push('seo')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($product->name) }}",
  "image": "{{ $product->image_url }}",
  "description": "{{ addslashes(Str::limit(strip_tags($product->description ?? ''), 200)) }}",
  "sku": "IRVANA-{{ $product->id }}",
  "brand": { "@type": "Brand", "name": "Irvana Buah" },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "{{ $product->effective_price }}",
    "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
    "seller": { "@type": "Organization", "name": "Irvana Buah" }
  }
}
</script>
@endpush

@endsection