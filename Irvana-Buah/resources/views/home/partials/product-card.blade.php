<div class="{{ $colClass ?? 'col-6 col-sm-6 col-lg-4 col-xl-3' }} product-item">
    <div class="irvana-product-box">
        <div class="irvana-product-thumb">

            {{-- Left-side labels stack (Habis / Baru) --}}
            @if($product->stock <= 0 || $product->is_new)
            <div class="irvana-labels-stack">
                @if($product->stock <= 0)
                    <span class="irvana-label irvana-label-sold">Habis</span>
                @elseif($product->is_new)
                    <span class="irvana-label irvana-label-new">Baru</span>
                @endif
            </div>
            @endif

            {{-- Right-side: discount % --}}
            @if($product->has_discount)
                <span class="irvana-label-sale-topright">-{{ $product->discount_percentage }}%</span>
            @endif

            <img src="{{ $product->image_url }}"
                 alt="{{ $product->name }}"
                 class="irvana-main-img"
                 loading="lazy"
                 onerror="this.src='{{ asset('assets/img/product/product-1.webp') }}'">

            {{-- Desktop hover overlay --}}
            <div class="irvana-overlay">
                <div class="irvana-quick-actions">
                    <button type="button" class="irvana-action-btn" title="Wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <a href="{{ route('product.detail', $product->slug) }}" class="irvana-action-btn" title="Lihat Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
                <div class="irvana-cart-area">
                    @if($product->stock > 0)
                        @auth
                            <button type="button" class="irvana-cart-btn btn-add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}">
                                <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="irvana-cart-btn">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Beli
                            </a>
                        @endauth
                    @else
                        <button class="irvana-cart-btn irvana-cart-disabled" disabled>
                            <i class="bi bi-x-circle me-1"></i> Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="irvana-product-content">
            @if($product->category)
                <a href="{{ route('products.by.category', $product->category->slug) }}" class="irvana-category-tag">
                    {{ $product->category->name }}
                </a>
            @endif
            <h3 class="irvana-product-title">
                <a href="{{ route('product.detail', $product->slug) }}">{{ Str::limit($product->name, 38) }}</a>
            </h3>
            <div class="irvana-product-price">
                @if($product->has_discount)
                    <span class="irvana-price-sale">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    <span class="irvana-price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    <span class="irvana-price-normal">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>
            <div class="irvana-stock-status">
                @if($product->stock <= 0)
                    <span class="irvana-stock-out"><i class="bi bi-x-circle me-1"></i>Stok habis</span>
                @elseif($product->stock <= 5)
                    <span class="irvana-stock-low"><i class="bi bi-exclamation-circle me-1"></i>Sisa {{ $product->stock }}</span>
                @else
                    <span class="irvana-stock-ok"><i class="bi bi-check-circle me-1"></i>Tersedia</span>
                @endif
            </div>
        </div>

        {{-- Mobile always-visible cart button (replaces hover overlay on touch) --}}
        @if($product->stock > 0)
            @auth
                <button type="button" class="irvana-mobile-cart btn-add-to-cart"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}">
                    <i class="bi bi-cart-plus me-1"></i>Tambah
                </button>
            @else
                <a href="{{ route('login') }}" class="irvana-mobile-cart" style="text-decoration:none;display:none;">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
            @endauth
        @else
            <button class="irvana-mobile-cart sold-out" disabled>Stok Habis</button>
        @endif

    </div>
</div>
