@extends('home.app')

@section('title', 'Irvana Buah - Produk')

@section('styles')
<style>
/* ===== CARD LEBIH BESAR & MENARIK ===== */
.category-product-list .product-thumb { padding-bottom: 72%; }
.category-product-list .product-box {
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.category-product-list .product-box:hover {
  transform: translateY(-6px);
  box-shadow: 0 14px 36px rgba(0,0,0,0.14);
}
.category-product-list .product-content { padding: 1.25rem 1.5rem 1.5rem; }
.category-product-list .product-title { font-size: 1.05rem; height: auto; margin-bottom: 0.5rem; }
.category-product-list .product-price span { font-size: 1.1rem; }

/* ===== TOMBOL KONSISTEN ===== */
.category-product-list .add-to-cart-btn {
  width: 100%; padding: 0.75rem 1rem;
  background-color: var(--accent-color); color: #fff;
  border: 2px solid var(--accent-color); border-radius: 50px;
  font-weight: 600; font-size: 0.875rem; cursor: pointer;
  transition: all 0.25s ease;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.category-product-list .add-to-cart-btn:hover:not(.disabled) {
  background-color: transparent; color: var(--accent-color);
}
.category-product-list .add-to-cart-btn.disabled {
  background: #e2e8f0; border-color: #e2e8f0; color: #94a3b8; cursor: not-allowed;
}
.category-product-list .add-to-cart-btn.success {
  background-color: #16a34a; border-color: #16a34a; color: #fff;
}
.rating-stars i { font-size: 0.78rem; }
</style>
@endsection

@section('content')
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Produk Buah</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Produk</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <div class="container">
      <div class="row">
        <!-- Sidebar Kategori -->
        <div class="col-lg-3 sidebar">
          <div class="widgets-container">
            <!-- Widget Kategori -->
            <div class="product-categories-widget widget-item">
              <h3 class="widget-title">Kategori Buah</h3>
              <ul class="category-tree list-unstyled mb-0">
                @foreach($categories as $category)
                  <li class="category-item">
                    <div class="d-flex justify-content-between align-items-center category-header">
                      <a href="{{ route('products.by.category', $category->slug) }}" class="category-link">
                        {{ $category->name }}
                      </a>
                      @if($category->products_count > 0)
                        <span class="badge bg-primary rounded-pill ms-2">
                          {{ $category->products_count }}
                        </span>
                      @endif
                    </div>
                  </li>
                @endforeach
              </ul>
            </div><!-- End Widget Kategori -->

            <!-- Filter Harga -->
            <div class="pricing-range-widget widget-item">
              <h3 class="widget-title">Filter Harga</h3>
              <div class="price-range-container">
                <div class="current-range mb-3">
                  <span class="min-price">Rp 0</span>
                  <span class="max-price float-end">Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                </div>
                <div class="range-slider">
                  <div class="slider-track"></div>
                  <div class="slider-progress"></div>
                  <input type="range" class="min-range" min="0" max="{{ $maxPrice }}" value="0" step="1000">
                  <input type="range" class="max-range" min="0" max="{{ $maxPrice }}" value="{{ $maxPrice }}" step="1000">
                </div>
                <div class="price-inputs mt-3">
                  <div class="row g-2">
                    <div class="col-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control min-price-input" placeholder="Min" min="0" max="{{ $maxPrice }}" value="0" step="1000">
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control max-price-input" placeholder="Max" min="0" max="{{ $maxPrice }}" value="{{ $maxPrice }}" step="1000">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="filter-actions mt-3">
                  <button type="button" class="btn btn-sm btn-primary w-100 apply-filter-btn">Terapkan Filter</button>
                </div>
              </div>
            </div><!-- End Filter Harga -->
          </div>
        </div><!-- End Sidebar -->

        <!-- Daftar Produk -->
        <div class="col-lg-9">
          <!-- Filter dan Sorting -->
          <section id="category-header" class="category-header section">
            <div class="container" data-aos="fade-up">
              <div class="filter-container mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-3">
                  <div class="col-12 col-md-6 col-lg-4">
                    <div class="filter-item search-form">
                      <label for="productSearch" class="form-label">Cari Produk</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="productSearch" placeholder="Cari produk..." aria-label="Cari produk">
                        <button class="btn search-btn" type="button">
                          <i class="bi bi-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-3">
                    <div class="filter-item">
                      <label for="priceRange" class="form-label">Rentang Harga</label>
                      <select class="form-select" id="priceRange">
                        <option selected>Semua Harga</option>
                        <option value="0-25000">Rp 0 - 25.000</option>
                        <option value="25000-50000">Rp 25.000 - 50.000</option>
                        <option value="50000-100000">Rp 50.000 - 100.000</option>
                        <option value="100000-200000">Rp 100.000 - 200.000</option>
                        <option value="200000-{{ $maxPrice }}">Rp 200.000+</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-3">
                    <div class="filter-item">
                      <label for="sortBy" class="form-label">Urutkan</label>
                      <select class="form-select" id="sortBy">
                        <option selected value="newest">Terbaru</option>
                        <option value="price_low">Harga: Rendah ke Tinggi</option>
                        <option value="price_high">Harga: Tinggi ke Rendah</option>
                        <option value="name_asc">Nama: A-Z</option>
                        <option value="name_desc">Nama: Z-A</option>
                        <option value="popular">Terpopuler</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-2">
                    <div class="filter-item">
                      <label class="form-label">Tampilan</label>
                      <div class="view-options">
                        <button type="button" class="btn view-btn active" data-view="grid" aria-label="Grid view">
                          <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button type="button" class="btn view-btn" data-view="list" aria-label="List view">
                          <i class="bi bi-list-ul"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Daftar Produk -->
          <section id="category-product-list" class="category-product-list section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
              <div class="row gy-4" id="products-container">
                @forelse($products as $product)
                  <div class="col-12 col-sm-6 col-lg-4 col-xl-4 product-item">
                    <div class="product-box">
                      <div class="product-thumb">
                        @if($product->has_discount)
                          <span class="product-label product-label-sale">-{{ $product->discount_percentage }}%</span>
                        @endif
                        @if($product->stock <= 0)
                          <span class="product-label product-label-sold">Habis</span>
                        @elseif($product->is_new)
                          <span class="product-label">Baru</span>
                        @endif
                        
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-img" loading="lazy">
                        
                        <div class="product-overlay">
                          <div class="product-quick-actions">
                            <button type="button" class="quick-action-btn" title="Tambahkan ke Wishlist">
                              <i class="bi bi-heart"></i>
                            </button>
                            <button type="button" class="quick-action-btn" title="Bandingkan">
                              <i class="bi bi-arrow-repeat"></i>
                            </button>
                            <button type="button" class="quick-action-btn quick-view-btn" 
                                    data-product-id="{{ $product->id }}" title="Lihat Detail">
                              <i class="bi bi-eye"></i>
                            </button>
                          </div>
                          <div class="add-to-cart-container">
                            @if($product->stock > 0)
                              <button type="button" class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                              </button>
                            @else
                              <button type="button" class="add-to-cart-btn disabled" disabled>
                                Stok Habis
                              </button>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="product-content">
                        <div class="product-details">
                          <h3 class="product-title">
                            <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                          </h3>
                          <div class="product-price">
                            @if($product->has_discount)
                              <span class="original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                              <span class="sale">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                              <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                          </div>
                        </div>
                        <div class="product-rating-container">
                          <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                              @if($i <= floor($product->average_rating))
                                <i class="bi bi-star-fill"></i>
                              @elseif($i == ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) >= 0.5)
                                <i class="bi bi-star-half"></i>
                              @else
                                <i class="bi bi-star"></i>
                              @endif
                            @endfor
                          </div>
                          <span class="rating-number">{{ number_format($product->average_rating, 1) }}</span>
                        </div>
                        <div class="product-stock-status">
                          @if($product->stock <= 0)
                            <span class="text-danger">Stok habis</span>
                          @elseif($product->stock <= 5)
                            <span class="text-warning">Stok terbatas ({{ $product->stock }})</span>
                          @else
                            <span class="text-success">Stok tersedia</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="col-12">
                    <div class="text-center py-5">
                      <div class="empty-state">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <h4 class="mt-3">Tidak ada produk ditemukan</h4>
                        <p class="text-muted">Coba ubah filter pencarian atau kata kunci Anda.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">Lihat Semua Produk</a>
                      </div>
                    </div>
                  </div>
                @endforelse
              </div>
            </div>
          </section><!-- End Daftar Produk -->

          <!-- Pagination -->
          @if($products->hasPages())
          <section id="category-pagination" class="category-pagination section">
            <div class="container">
              {{ $products->links() }}
            </div>
          </section><!-- End Pagination -->
          @endif
        </div><!-- End Daftar Produk -->
      </div>
    </div>
  </main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize variables
    let currentUrl = new URL(window.location.href);
    let searchTimeout;

    // Filter harga slider
    $('.min-range, .max-range').on('input', function() {
        let minVal = parseInt($('.min-range').val());
        let maxVal = parseInt($('.max-range').val());
        
        // Prevent overlap
        if (minVal > maxVal - 1000) {
            minVal = maxVal - 1000;
            $('.min-range').val(minVal);
        }
        if (maxVal < minVal + 1000) {
            maxVal = minVal + 1000;
            $('.max-range').val(maxVal);
        }
        
        $('.min-price-input').val(minVal);
        $('.max-price-input').val(maxVal);
        
        updateSliderProgress(minVal, maxVal);
        updatePriceDisplay(minVal, maxVal);
    });

    // Input harga manual
    $('.min-price-input, .max-price-input').on('input', function() {
        let minVal = parseInt($('.min-price-input').val()) || 0;
        let maxVal = parseInt($('.max-price-input').val()) || {{ $maxPrice }};
        
        // Validation
        if (minVal < 0) minVal = 0;
        if (maxVal > {{ $maxPrice }}) maxVal = {{ $maxPrice }};
        if (minVal >= maxVal) minVal = maxVal - 1000;
        
        $('.min-range').val(minVal);
        $('.max-range').val(maxVal);
        $('.min-price-input').val(minVal);
        $('.max-price-input').val(maxVal);
        
        updateSliderProgress(minVal, maxVal);
        updatePriceDisplay(minVal, maxVal);
    });

    function updateSliderProgress(minVal, maxVal) {
        let maxRange = {{ $maxPrice }};
        let percent1 = (minVal / maxRange) * 100;
        let percent2 = (maxVal / maxRange) * 100;
        
        $('.slider-progress').css({
            'left': percent1 + '%',
            'width': (percent2 - percent1) + '%'
        });
    }

    function updatePriceDisplay(minVal, maxVal) {
        $('.min-price').text(formatRupiah(minVal));
        $('.max-price').text(formatRupiah(maxVal));
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Apply price filter
    $('.apply-filter-btn').on('click', function() {
        let minPrice = $('.min-price-input').val();
        let maxPrice = $('.max-price-input').val();
        
        currentUrl.searchParams.set('min_price', minPrice);
        currentUrl.searchParams.set('max_price', maxPrice);
        currentUrl.searchParams.delete('page'); // Reset pagination
        
        window.location.href = currentUrl.toString();
    });

    // Search functionality
    $('#productSearch').on('input', function() {
        clearTimeout(searchTimeout);
        let query = $(this).val();
        
        searchTimeout = setTimeout(function() {
            if (query.length >= 2 || query.length === 0) {
                currentUrl.searchParams.set('search', query);
                currentUrl.searchParams.delete('page');
                window.location.href = currentUrl.toString();
            }
        }, 500);
    });

    // Price range dropdown
    $('#priceRange').on('change', function() {
        let range = $(this).val();
        if (range && range !== 'Semua Harga') {
            let [min, max] = range.split('-').map(val => parseInt(val));
            currentUrl.searchParams.set('min_price', min);
            currentUrl.searchParams.set('max_price', max);
            currentUrl.searchParams.delete('page');
            window.location.href = currentUrl.toString();
        }
    });

    // Sort functionality
    $('#sortBy').on('change', function() {
        let sortValue = $(this).val();
        currentUrl.searchParams.set('sort', sortValue);
        currentUrl.searchParams.delete('page');
        window.location.href = currentUrl.toString();
    });

    // View toggle
    $('.view-btn').on('click', function() {
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        
        let viewType = $(this).data('view');
        let container = $('#products-container');
        
        if (viewType === 'list') {
            container.removeClass('row gy-4').addClass('list-view');
            $('.product-item').removeClass('col-6 col-md-4 col-lg-4 col-xl-3').addClass('col-12');
        } else {
            container.removeClass('list-view').addClass('row gy-4');
            $('.product-item').removeClass('col-12').addClass('col-6 col-md-4 col-lg-4 col-xl-3');
        }
    });

    // Add to cart functionality
    $('.add-to-cart-btn:not(.disabled)').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        var button = $(this);
        var origHTML = button.html();

        button.prop('disabled', true);
        button.html('<i class="bi bi-hourglass-split"></i> Menambahkan...');

        $.ajax({
            url: '{{ route("cart.store") }}',
            method: 'POST',
            data: { product_id: productId, quantity: 1, _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    $('#cart-badge').text(response.cart_count);
                    button.addClass('success');
                    button.html('<i class="bi bi-check-circle-fill"></i> Ditambahkan!');
                    setTimeout(function() {
                        button.prop('disabled', false);
                        button.removeClass('success');
                        button.html(origHTML);
                    }, 2000);
                } else {
                    button.prop('disabled', false);
                    button.html(origHTML);
                    // Tampilkan pesan error kecil di bawah tombol
                    var errEl = $('<div class="text-danger small mt-1">' + (response.message || 'Gagal menambahkan') + '</div>');
                    button.after(errEl);
                    setTimeout(function() { errEl.remove(); }, 3000);
                }
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(origHTML);
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                }
            }
        });
    });

    // Quick view functionality
    $('.quick-view-btn').on('click', function() {
        let productId = $(this).data('product-id');
        // Redirect to product detail page
        window.location.href = '/product/' + productId;
    });

    // Initialize price range display
    updateSliderProgress(0, {{ $maxPrice }});
    updatePriceDisplay(0, {{ $maxPrice }});
});
</script>
@endsection