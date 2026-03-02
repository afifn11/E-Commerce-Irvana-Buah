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

    // ── Update quantity ──────────────────────────────────────
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        let timeout;
        input.addEventListener('change', function() {
            clearTimeout(timeout);
            const id       = this.dataset.id;
            const quantity = parseInt(this.value) || 1;
            timeout = setTimeout(() => updateCart(id, quantity), 500);
        });
    });

    // ── Remove item with custom confirm toast ────────────────
    document.querySelectorAll('.remove-item').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id   = this.dataset.id;
            const row  = document.querySelector(`.cart-item[data-id="${id}"]`);
            const name = row ? row.querySelector('.product-title')?.textContent?.trim() : 'produk ini';
            showDeleteConfirm(name, () => removeFromCart(id));
        });
    });

    // ── Custom delete confirm dialog ─────────────────────────
    function showDeleteConfirm(productName, onConfirm) {
        // Remove existing
        document.getElementById('irvana-confirm')?.remove();

        const modal = document.createElement('div');
        modal.id = 'irvana-confirm';
        modal.innerHTML = `
          <div id="irvana-confirm-backdrop" style="
            position:fixed;inset:0;background:rgba(0,0,0,0.45);
            z-index:9999;display:flex;align-items:center;justify-content:center;
            animation:fadeIn .2s ease;
          ">
            <div style="
              background:#fff;border-radius:16px;padding:28px 28px 22px;
              max-width:360px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.2);
              animation:slideUp .25s ease;text-align:center;
            ">
              <div style="width:56px;height:56px;background:#FEE2E2;border-radius:50%;
                display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="bi bi-trash3" style="font-size:1.5rem;color:#ef4444;"></i>
              </div>
              <h5 style="margin:0 0 8px;font-weight:700;color:#111;">Hapus dari Keranjang?</h5>
              <p style="color:#666;font-size:0.9rem;margin:0 0 22px;">
                <strong>${productName}</strong> akan dihapus dari keranjang belanja Anda.
              </p>
              <div style="display:flex;gap:10px;justify-content:center;">
                <button id="irvana-cancel-btn" style="
                  flex:1;padding:10px;border-radius:10px;border:1.5px solid #ddd;
                  background:#fff;font-weight:600;cursor:pointer;font-size:0.9rem;
                ">Batal</button>
                <button id="irvana-confirm-btn" style="
                  flex:1;padding:10px;border-radius:10px;border:none;
                  background:#ef4444;color:#fff;font-weight:700;cursor:pointer;font-size:0.9rem;
                ">Hapus</button>
              </div>
            </div>
          </div>`;

        document.body.appendChild(modal);

        document.getElementById('irvana-cancel-btn').onclick  = () => modal.remove();
        document.getElementById('irvana-confirm-btn').onclick = () => { modal.remove(); onConfirm(); };
        document.getElementById('irvana-confirm-backdrop').onclick = (e) => {
            if(e.target === e.currentTarget) modal.remove();
        };
    }

    // ── Toast notification ───────────────────────────────────
    function showToast(msg, type = 'success') {
        const el = document.createElement('div');
        el.style.cssText = `
          position:fixed;top:20px;right:20px;z-index:10000;
          padding:12px 20px;border-radius:10px;font-weight:600;font-size:0.9rem;
          background:${type==='success'?'#22c55e':'#ef4444'};color:#fff;
          box-shadow:0 4px 16px rgba(0,0,0,0.15);animation:slideIn .3s ease;
          display:flex;align-items:center;gap:8px;
        `;
        el.innerHTML = `<i class="bi bi-${type==='success'?'check-circle-fill':'exclamation-circle-fill'}"></i> ${msg}`;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 3000);
    }

    // ── Update cart item ─────────────────────────────────────
    function updateCart(id, quantity) {
        fetch(`/cart/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({ quantity })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Update subtotal
                const totalEl = document.getElementById('cart-total-price');
                if (totalEl) totalEl.textContent = data.formatted_total_price;

                // Update item total (row-level)
                const row = document.querySelector(`.cart-item[data-id="${id}"]`);
                if (row) {
                    const priceRaw = row.querySelector('.current-price')?.textContent?.replace(/[^0-9]/g,'') || 0;
                    const itemTotalEl = row.querySelector('.item-total span');
                    if (itemTotalEl) {
                        const total = parseInt(priceRaw) * quantity;
                        itemTotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    }
                }

                // Update badge
                const badge = document.getElementById('cart-badge');
                if (badge && data.cart_count !== undefined) badge.textContent = data.cart_count;
            } else {
                showToast(data.message || 'Gagal memperbarui', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan', 'error'));
    }

    // ── Remove cart item ─────────────────────────────────────
    function removeFromCart(id) {
        const row = document.querySelector(`.cart-item[data-id="${id}"]`);
        if (row) {
            row.style.transition = 'opacity .3s, transform .3s';
            row.style.opacity    = '0';
            row.style.transform  = 'translateX(30px)';
        }

        fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => row?.remove(), 300);

                // Update subtotal live
                const totalEl = document.getElementById('cart-total-price');
                if (totalEl) totalEl.textContent = data.formatted_total_price;

                // Update badge
                const badge = document.getElementById('cart-badge');
                if (badge) badge.textContent = data.cart_count;

                showToast('Produk berhasil dihapus dari keranjang');

                // If cart empty → hide summary, show empty state
                if (data.cart_count == 0) {
                    setTimeout(() => {
                        const cartItemsEl = document.querySelector('.cart-items');
                        if (cartItemsEl) {
                            cartItemsEl.innerHTML = `
                              <div class="text-center py-5">
                                <div style="font-size:4rem;color:#ddd;margin-bottom:1rem;">🛒</div>
                                <h4 style="color:#555;">Keranjang Anda kosong</h4>
                                <p class="text-muted">Yuk tambahkan produk ke keranjang!</p>
                                <a href="{{ route('products') }}" class="btn btn-primary mt-2">Mulai Belanja</a>
                              </div>`;
                        }
                        // Hide summary column
                        const summaryEl = document.querySelector('.cart-summary');
                        if (summaryEl) summaryEl.closest('.col-lg-4').style.display = 'none';

                        // Hide header row
                        const headerEl = document.querySelector('.cart-header');
                        if (headerEl) headerEl.style.display = 'none';
                    }, 350);
                }
            } else {
                if (row) { row.style.opacity = '1'; row.style.transform = ''; }
                showToast(data.message || 'Gagal menghapus', 'error');
            }
        })
        .catch(() => {
            if (row) { row.style.opacity = '1'; row.style.transform = ''; }
            showToast('Terjadi kesalahan', 'error');
        });
    }
});
</script>
<style>
@keyframes fadeIn  { from { opacity:0 } to { opacity:1 } }
@keyframes slideUp { from { transform:translateY(20px);opacity:0 } to { transform:translateY(0);opacity:1 } }
@keyframes slideIn { from { transform:translateX(30px);opacity:0 } to { transform:translateX(0);opacity:1 } }
</style>
@endsection
