@extends('home.app')

@section('title', 'Irvana Buah - Keranjang Belanja')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Keranjang Belanja</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Keranjang</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="cart" class="cart section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <div class="cart-items">
                @if($cartItems->isEmpty())
                    <div class="text-center py-5">
                        <h4>Keranjang Anda masih kosong.</h4>
                        <a href="{{ route('products') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
                    </div>
                @else
                    <div class="cart-header d-none d-lg-block">
                        <div class="row align-items-center gy-4">
                            <div class="col-lg-6"><h5>Produk</h5></div>
                            <div class="col-lg-2 text-center"><h5>Harga</h5></div>
                            <div class="col-lg-2 text-center"><h5>Kuantitas</h5></div>
                            <div class="col-lg-2 text-center"><h5>Total</h5></div>
                        </div>
                    </div>
                    @foreach($cartItems as $item)
                    <div class="cart-item" data-id="{{ $item->id }}">
                        <div class="row align-items-center gy-4">
                            <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                                <div class="product-info d-flex align-items-center">
                                    <div class="product-image">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid" loading="lazy">
                                    </div>
                                    <div class="product-details">
                                        <h6 class="product-title"><a href="{{ route('product.detail', $item->product->slug) }}">{{ $item->product->name }}</a></h6>
                                        <button class="remove-item" type="button" data-id="{{ $item->id }}"><i class="bi bi-trash"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 text-center">
                                <div class="price-tag">
                                    <span class="current-price">Rp {{ number_format($item->product->effective_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 text-center">
                                <div class="quantity-selector">
                                    <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" data-id="{{ $item->id }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 text-center mt-3 mt-lg-0">
                                <div class="item-total">
                                    <span>Rp {{ number_format($item->quantity * $item->product->effective_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
          </div>
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            @if(!$cartItems->isEmpty())
            <div class="cart-summary">
              <h4 class="summary-title">Ringkasan Pesanan</h4>
              <div class="summary-item">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value" id="cart-total-price">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
              </div>
              <div class="checkout-button">
                <a href="{{ route('cart.checkout') }}" class="btn btn-accent w-100">Lanjutkan ke Checkout <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        let timeout;
        input.addEventListener('change', function() {
            clearTimeout(timeout);
            const id = this.dataset.id;
            const quantity = this.value;
            timeout = setTimeout(() => updateCart(id, quantity), 500);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if(confirm('Hapus produk dari keranjang?')) {
                removeFromCart(id);
            }
        });
    });

    function updateCart(id, quantity) {
        fetch(`/cart/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                document.getElementById('cart-total-price').textContent = data.formatted_total_price;
                updateItemTotal(id, quantity);
            } else {
                alert(data.message);
            }
        });
    }

    function updateItemTotal(id, quantity) {
        const row = document.querySelector(`.cart-item[data-id="${id}"]`);
        if(row) {
            const price = parseFloat(row.querySelector('.current-price').textContent.replace(/[^0-9]/g,''));
            // Reload to recalculate (simpler approach)
            location.reload();
        }
    }

    function removeFromCart(id) {
        fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                document.querySelector(`.cart-item[data-id="${id}"]`).remove();
                document.getElementById('cart-total-price').textContent = data.formatted_total_price;
                document.getElementById('cart-badge').textContent = data.cart_count;
                if(data.cart_count == 0) location.reload();
            }
        });
    }
});
</script>
@endsection
