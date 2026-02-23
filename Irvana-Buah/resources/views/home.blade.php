@extends('home.app')

@section('title', 'Irvana Buah - Home')

@section('content')
<main class="main">

    <section class="ecommerce-hero-1 hero section" id="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
        <div class="content">
          <span class="promo-badge">Segar Setiap Hari</span>
          <h1>Buah <span>Segar</span> Berkualitas Terbaik Untuk Keluarga</h1>
          <p>Irvana Buah menyediakan buah-buahan segar berkualitas premium langsung dari kebun pilihan. Nikmati kesegaran dan nutrisi terbaik untuk hidup yang lebih sehat.</p>
          <div class="hero-cta">
            <a href="{{ route('products') }}" class="btn btn-shop">Belanja Sekarang <i class="bi bi-arrow-right"></i></a>
            <a href="{{ route('discount.products') }}" class="btn btn-collection">Buah Diskon Hari Ini</a>
          </div>
          <div class="hero-features">
            <div class="feature-item">
              <i class="bi bi-truck"></i>
              <span>Pengiriman Cepat</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-shield-check"></i>
              <span>Jaminan Segar</span>
            </div>
            <div class="feature-item">
              <i class="bi bi-award"></i>
              <span>Kualitas Premium</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 image-col" data-aos="fade-left" data-aos-delay="200">
        <div class="hero-image">
          <img src="{{ asset('assets/img/fruits/main-fruits.webp') }}" alt="Buah Segar Irvana" class="main-product" loading="lazy">
          
          @if($discountedProducts->count() > 0)
            @foreach($discountedProducts->take(2) as $index => $product)
              <div class="floating-product product-{{ $index + 1 }}" data-aos="fade-up" data-aos-delay="{{ 300 + ($index * 100) }}">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                     onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
                <div class="product-info">
                  <h4>{{ $product->name }}</h4>
                  <div class="price-container">
                    @if($product->has_discount)
                      <span class="original-price">Rp {{ number_format($product->price, 0, ',', '.') }}/kg</span>
                      <span class="discount-price">Rp {{ number_format($product->discount_price, 0, ',', '.') }}/kg</span>
                    @else
                      <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}/kg</span>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
            
            {{-- Discount badge menampilkan diskon terbesar --}}
            @php
              $maxDiscount = $discountedProducts->max('discount_percentage');
            @endphp
            <div class="discount-badge" data-aos="zoom-in" data-aos-delay="500">
              <span class="percent">{{ $maxDiscount }}%</span>
              <span class="text">OFF</span>
            </div>
          @else
            {{-- Fallback jika tidak ada produk diskon --}}
            <div class="floating-product product-1" data-aos="fade-up" data-aos-delay="300">
              <img src="{{ asset('assets/img/fruits/apple-fresh.webp') }}" alt="Apel Segar">
              <div class="product-info">
                <h4>Apel Fuji</h4>
                <span class="price">Rp 35.000/kg</span>
              </div>
            </div>
            <div class="floating-product product-2" data-aos="fade-up" data-aos-delay="400">
              <img src="{{ asset('assets/img/fruits/orange-fresh.webp') }}" alt="Jeruk Segar">
              <div class="product-info">
                <h4>Jeruk Manis</h4>
                <span class="price">Rp 28.000/kg</span>
              </div>
            </div>
            <div class="discount-badge" data-aos="zoom-in" data-aos-delay="500">
              <span class="percent">25%</span>
              <span class="text">OFF</span>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* Tambahan CSS untuk styling harga diskon */
.floating-product .price-container {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.floating-product .original-price {
  text-decoration: line-through;
  color: #999;
  font-size: 0.8em;
}

.floating-product .discount-price {
  color: #e74c3c;
  font-weight: bold;
  font-size: 0.9em;
}

.floating-product .price {
  color: #2c3e50;
  font-weight: bold;
  font-size: 0.9em;
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
  .floating-product .price-container {
    font-size: 0.8em;
  }
  
  .floating-product h4 {
    font-size: 0.9em;
  }
}
</style>

    
    <section id="info-cards" class="info-cards section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 justify-content-center">
          <div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-truck"></i>
              </div>
              <h3>Pengiriman Cepat</h3>
              <p>Kami menjamin pengiriman buah segar langsung ke rumah Anda dalam waktu 24 jam untuk wilayah Jakarta dan sekitarnya.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-award"></i>
              </div>
              <h3>Kualitas Terjamin</h3>
              <p>Semua buah dipilih langsung dari petani terpercaya dengan standar kualitas premium dan kesegaran terbaik.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-leaf"></i>
              </div>
              <h3>Buah Organik</h3>
              <p>Menyediakan pilihan buah organik tanpa pestisida untuk kesehatan keluarga Anda yang lebih baik.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-chat-dots"></i>
              </div>
              <h3>Layanan Pelanggan</h3>
              <p>Tim customer service kami siap membantu Anda setiap hari untuk memastikan kepuasan berbelanja buah.</p>
            </div>
          </div></div>

      </div>

    </section>

    <section id="category-cards" class="category-cards section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="category-slider swiper init-swiper">
            <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "autoplay": {
                "delay": 5000,
                "disableOnInteraction": false
              },
              "grabCursor": true,
              "speed": 600,
              "slidesPerView": "auto",
              "spaceBetween": 20,
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 15
                },
                "576": {
                  "slidesPerView": 3,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "spaceBetween": 20
                },
                "992": {
                  "slidesPerView": 5,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 6,
                  "spaceBetween": 20
                }
              }
            }
            </script>

            <div class="swiper-wrapper">
                @forelse($categories as $index => $category)
                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="{{ ($index % 8 + 1) * 100 }}">
                            <div class="category-image">
                                <img src="{{ $category->image_url ?? asset('assets/img/product/product-1.webp') }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-fluid"
                                     onerror="this.src='{{ asset('assets/img/product/product-1.webp') }}'">
                            </div>
                            <h3 class="category-title">{{ $category->name }}</h3>
                            <p class="category-count">{{ $category->products_count }} Products</p>
                            <a href="{{ route('products.by.category', $category->slug) }}" class="stretched-link"></a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback static categories jika tidak ada data dinamis -->
                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-1.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Vestibulum ante</h3>
                            <p class="category-count">4 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-6.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Maecenas nec</h3>
                            <p class="category-count">8 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-9.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Aenean tellus</h3>
                            <p class="category-count">4 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-f-1.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Donec quam</h3>
                            <p class="category-count">12 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-10.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Phasellus leo</h3>
                            <p class="category-count">4 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="600">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-m-1.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Quisque rutrum</h3>
                            <p class="category-count">2 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="700">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-10.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Etiam ultricies</h3>
                            <p class="category-count">4 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card" data-aos="fade-up" data-aos-delay="800">
                            <div class="category-image">
                                <img src="{{ asset('assets/img/product/product-2.webp') }}" alt="Category" class="img-fluid">
                            </div>
                            <h3 class="category-title">Fusce fermentum</h3>
                            <p class="category-count">4 Products</p>
                            <a href="{{ url('/category') }}" class="stretched-link"></a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

    <!-- Best Sellers Section -->
<section id="best-sellers" class="best-sellers section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Best Sellers</h2>
        <p>Produk buah segar terlaris pilihan pelanggan kami</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            @forelse($bestSellerProducts as $index => $product)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 50) }}">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image_url }}" 
                                 class="img-fluid default-image" 
                                 alt="{{ $product->name }}" 
                                 loading="lazy"
                                 onerror="this.src='{{ asset('images/default-product.png') }}'">
                            
                            <!-- Product Tags -->
                            <div class="product-tags">
                                @if($product->is_new)
                                    <span class="badge bg-accent">New</span>
                                @endif
                                @if($product->has_discount)
                                    <span class="badge bg-sale">Sale {{ $product->discount_percentage }}%</span>
                                @endif
                                @if($product->is_low_stock)
                                    <span class="badge bg-warning">Stock Terbatas</span>
                                @endif
                                @if($product->stock <= 0)
                                    <span class="badge bg-sold-out">Stok Habis</span>
                                @endif
                            </div>
                            
                            <!-- Product Actions -->
                            <div class="product-actions">
                                <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <button class="btn-quickview" type="button" aria-label="Quick view" data-product-id="{{ $product->id }}" data-product-slug="{{ $product->slug }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            
                            <!-- Product Price -->
                            <div class="product-price">
                                @if($product->has_discount)
                                    <span class="current-price">{{ $product->formatted_discount_price }}</span>
                                    <span class="original-price">{{ $product->formatted_price }}</span>
                                @else
                                    <span class="current-price">{{ $product->formatted_price }}</span>
                                @endif
                            </div>
                            
                            <!-- Product Rating & Sales Info -->
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i <= ceil($product->average_rating))
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <span class="rating-count">({{ $product->total_sold ?? 0 }} terjual)</span>
                            </div>
                            
                            <!-- Category Info -->
                            <div class="product-category">
                                <small class="text-muted">{{ $product->category->name ?? 'Buah Segar' }}</small>
                            </div>
                            
                            <!-- Add to Cart Button -->
                            @if($product->stock > 0)
                                <button class="btn btn-add-to-cart" 
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->effective_price }}">
                                    <i class="bi bi-bag-plus me-2"></i>Tambah ke Keranjang
                                </button>
                            @else
                                <button class="btn btn-add-to-cart btn-disabled" disabled>
                                    <i class="bi bi-bag-plus me-2"></i>Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback jika tidak ada produk best seller -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-3 text-muted">Belum ada produk best seller untuk ditampilkan</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">
                            Lihat Semua Produk
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        
    </div>
</section>

<style>
/* Additional CSS for Best Sellers Section */
.best-sellers .product-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.best-sellers .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0,0,0,0.15);
}

.best-sellers .product-image {
    position: relative;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
    height: 250px;
}

.best-sellers .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.best-sellers .product-card:hover .product-image img {
    transform: scale(1.05);
}

.best-sellers .product-tags {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

.best-sellers .product-tags .badge {
    display: block;
    margin-bottom: 5px;
    font-size: 0.75rem;
    padding: 4px 8px;
}

.best-sellers .badge.bg-accent {
    background-color: #28a745 !important;
}

.best-sellers .badge.bg-sale {
    background-color: #dc3545 !important;
}

.best-sellers .badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000;
}

.best-sellers .badge.bg-sold-out {
    background-color: #6c757d !important;
}

.best-sellers .product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.best-sellers .product-card:hover .product-actions {
    opacity: 1;
}

.best-sellers .btn-wishlist,
.best-sellers .btn-quickview {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.best-sellers .btn-wishlist:hover,
.best-sellers .btn-quickview:hover {
    background: #fff;
    color: #007bff;
    transform: scale(1.1);
}

.best-sellers .product-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.best-sellers .product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 10px;
    line-height: 1.4;
}

.best-sellers .product-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.best-sellers .product-title a:hover {
    color: #007bff;
}

.best-sellers .product-price {
    margin-bottom: 10px;
}

.best-sellers .current-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #007bff;
}

.best-sellers .original-price {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
    margin-left: 8px;
}

.best-sellers .product-rating {
    margin-bottom: 8px;
    color: #ffc107;
}

.best-sellers .rating-count {
    color: #666;
    font-size: 0.9rem;
    margin-left: 5px;
}

.best-sellers .product-category {
    margin-bottom: 15px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .best-sellers .product-image {
        height: 200px;
    }
    
    .best-sellers .product-info {
        padding: 15px;
    }
    
    .best-sellers .product-title {
        font-size: 1rem;
    }
    
    .best-sellers .current-price {
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick view functionality - redirect to product detail page
    const quickviewButtons = document.querySelectorAll('.btn-quickview');
    
    quickviewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const slug = this.dataset.productSlug;
            if (slug) {
                window.location.href = '/product/' + slug;
            }
        });
    });
});

// Helper function to show toast notifications
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'primary'} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add to toast container (create if doesn't exist)
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Show toast using Bootstrap
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        toast.remove();
    });
}

// Add spinning animation for loading icons
const style = document.createElement('style');
style.textContent = `
    .spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>

    <section id="product-list" class="product-list section">
        <div class="container isotope-layout" data-aos="fade-up" data-aos-delay="100" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <div class="row">
                <div class="col-12">
                    <div class="product-filters isotope-filters mb-5 d-flex justify-content-center" data-aos="fade-up">
                        <ul class="d-flex flex-wrap gap-2 list-unstyled">
                            <li class="filter-active" data-filter="*">All</li>
                            @foreach($categories as $category)
                                <li data-filter=".filter-{{ Str::slug($category->name) }}">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row product-container isotope-container" data-aos="fade-up" data-aos-delay="200">
                @foreach($allProducts as $product)
                    <div class="col-md-6 col-lg-3 product-item isotope-item filter-{{ Str::slug($product->category->name) }}">
                        <div class="product-card">
                            <div class="product-image">
                                @if($product->has_discount)
                                    <span class="badge">Sale</span>
                                @elseif($product->is_new)
                                    <span class="badge">New</span>
                                @endif
                                
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid main-img">
                                <!-- Jika Anda memiliki gambar hover, bisa ditambahkan di sini -->
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid hover-img">
                                
                                <div class="product-overlay">
                                    <button class="btn-cart btn-add-to-cart" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                    <div class="product-actions">
                                        <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                                        <a href="{{ route('product.detail', $product->slug) }}" class="action-btn"><i class="bi bi-eye"></i></a>
                                        <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">
                                    <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                </h5>
                                <div class="product-price">
                                    <span class="current-price">{{ $product->formatted_effective_price }}</span>
                                    @if($product->has_discount)
                                        <span class="old-price">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                                <div class="product-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->average_rating))
                                            <i class="bi bi-star-fill"></i>
                                        @elseif($i == ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) >= 0.5)
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                    <span>({{ $product->total_sold }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('products') }}" class="view-all-btn">View All Products <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
// Global Add to Cart handler for all pages
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-add-to-cart').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const origText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>...';
            
            fetch('{{ route("cart.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    const badge = document.getElementById('cart-badge');
                    if(badge) badge.textContent = data.cart_count;
                    this.innerHTML = '<i class="bi bi-check-circle me-1"></i>Ditambahkan!';
                    this.classList.add('btn-success');
                    this.classList.remove('btn-primary');
                } else {
                    if(data.message && data.message.includes('login')) {
                        window.location.href = '{{ route("login") }}';
                    } else {
                        alert(data.message || 'Gagal menambahkan ke keranjang');
                    }
                    this.disabled = false;
                    this.innerHTML = origText;
                }
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = origText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                }, 2000);
            })
            .catch(() => {
                this.disabled = false;
                this.innerHTML = origText;
            });
        });
    });
});
</script>
@endsection