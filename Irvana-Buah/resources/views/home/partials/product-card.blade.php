<div class="col-lg-3 col-md-4 col-6">
<div class="product-card h-100 d-flex flex-column">
    <div class="product-image position-relative overflow-hidden">
        <a href="{{ route('product.detail', $product->slug) }}">
            <img src="{{ $product->image_url }}" 
                 class="img-fluid w-100" 
                 alt="{{ $product->name }}" 
                 loading="lazy"
                 style="height: 200px; object-fit: cover;"
                 onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
        </a>
        
        <div class="position-absolute top-0 start-0 p-2" style="display:flex;gap:4px;flex-direction:column;">
            @if($product->is_new)
                <span class="badge bg-success">Baru</span>
            @endif
            @if($product->has_discount)
                <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
            @endif
            @if($product->stock_status === 'low_stock')
                <span class="badge bg-warning text-dark">Stok Terbatas</span>
            @endif
        </div>
    </div>
    
    <div class="product-info d-flex flex-column flex-grow-1 p-3">
        @if($product->category)
        <div class="mb-1">
            <small class="text-muted">
                <a href="{{ route('products.by.category', $product->category->slug) }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a>
            </small>
        </div>
        @endif
        <h3 class="product-title flex-grow-1 fs-6 mb-2">
            <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none text-dark">{{ Str::limit($product->name, 45) }}</a>
        </h3>
        
        <div class="product-price mb-2">
            @if($product->has_discount)
                <span class="current-price fw-bold text-danger">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                <span class="original-price text-muted text-decoration-line-through small ms-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @else
                <span class="current-price fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @endif
            <span class="text-muted small">/kg</span>
        </div>
        
        <div class="mt-auto">
            @if($product->stock > 0)
                @auth
                    <button class="btn btn-primary btn-sm w-100 btn-add-to-cart" 
                            data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login untuk Beli
                    </a>
                @endauth
            @else
                <button class="btn btn-secondary btn-sm w-100" disabled>
                    <i class="bi bi-x-circle me-1"></i>Stok Habis
                </button>
            @endif
        </div>
    </div>
</div>
</div>
