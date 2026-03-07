@extends('home.app')

@section('title', 'Irvana Buah - Checkout')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Checkout</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('cart.index') }}">Keranjang</a></li>
            <li class="current">Checkout</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-lg-7">
              <!-- Checkout Form -->
              <div class="checkout-container" data-aos="fade-up">

                <!-- Customer Information -->
                <div class="checkout-section" id="customer-info">
                  <div class="section-header">
                    <div class="section-number">1</div>
                    <h3>Informasi Penerima</h3>
                  </div>
                  <div class="section-content">
                    <div class="form-group mb-3">
                      <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                             id="name" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                      @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" 
                             name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                      @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="phone">Nomor Telepon <span class="text-danger">*</span></label>
                      <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                             name="phone" id="phone" value="{{ old('phone', Auth::user()->phone_number ?? '') }}" placeholder="+62 8xx-xxxx-xxxx" required>
                      @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>
                </div>

                <!-- Shipping Address -->
                <div class="checkout-section" id="shipping-address">
                  <div class="section-header">
                    <div class="section-number">2</div>
                    <h3>Alamat Pengiriman</h3>
                  </div>
                  <div class="section-content">
                    <div class="form-group mb-3">
                      <label for="address">Alamat Lengkap <span class="text-danger">*</span></label>
                      <textarea class="form-control @error('address') is-invalid @enderror" 
                                name="address" id="address" rows="3" placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan" required>{{ old('address', Auth::user()->address ?? '') }}</textarea>
                      @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="notes">Catatan Pesanan (opsional)</label>
                      <textarea class="form-control" name="notes" id="notes" rows="2" placeholder="Contoh: titip ke satpam, panggil via telepon sebelum kirim...">{{ old('notes') }}</textarea>
                    </div>
                  </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-section" id="payment-method">
                  <div class="section-header">
                    <div class="section-number">3</div>
                    <h3>Metode Pembayaran</h3>
                  </div>
                  <div class="section-content">
                    <div class="payment-options">
                      <div class="payment-option active" onclick="selectPayment(this, 'bank_transfer')">
                        <input type="radio" name="payment_method" id="bank-transfer" value="bank_transfer" checked>
                        <label for="bank-transfer">
                          <span class="payment-icon"><i class="bi bi-bank"></i></span>
                          <span class="payment-label">Transfer Bank</span>
                        </label>
                      </div>
                      <div class="payment-option" onclick="selectPayment(this, 'e_wallet')">
                        <input type="radio" name="payment_method" id="e-wallet" value="e_wallet">
                        <label for="e-wallet">
                          <span class="payment-icon"><i class="bi bi-phone"></i></span>
                          <span class="payment-label">Dompet Digital (GoPay/OVO)</span>
                        </label>
                      </div>
                      <div class="payment-option" onclick="selectPayment(this, 'cash')">
                        <input type="radio" name="payment_method" id="cash" value="cash">
                        <label for="cash">
                          <span class="payment-icon"><i class="bi bi-cash-coin"></i></span>
                          <span class="payment-label">COD / Bayar di Tempat</span>
                        </label>
                      </div>
                    </div>

                    <div id="bank_transfer-details" class="payment-details mt-3">
                      <div class="alert alert-info">
                        <strong><i class="bi bi-info-circle"></i> Informasi Transfer Bank:</strong><br>
                        BCA: <strong>1234567890</strong> a/n Irvana Buah<br>
                        Mandiri: <strong>0987654321</strong> a/n Irvana Buah<br>
                        <small class="text-muted">Konfirmasi pembayaran via WhatsApp: +62 812-3456-7890</small>
                      </div>
                    </div>
                    <div id="e_wallet-details" class="payment-details mt-3 d-none">
                      <div class="alert alert-info">
                        <strong><i class="bi bi-phone"></i> Dompet Digital:</strong><br>
                        GoPay/OVO: <strong>0812-3456-7890</strong> a/n Irvana Buah<br>
                        <small class="text-muted">Kirim bukti pembayaran via WhatsApp</small>
                      </div>
                    </div>
                    <div id="cash-details" class="payment-details mt-3 d-none">
                      <div class="alert alert-success">
                        <strong><i class="bi bi-check-circle"></i> COD / Bayar di Tempat:</strong><br>
                        Siapkan uang pas saat kurir tiba untuk mempercepat proses.<br>
                        <small class="text-muted">Area pengiriman: dalam kota (radius 20km)</small>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Review -->
                <div class="checkout-section" id="order-review">
                  <div class="section-header">
                    <div class="section-number">4</div>
                    <h3>Konfirmasi Pesanan</h3>
                  </div>
                  <div class="section-content">
                    <div class="form-check terms-check mb-3">
                      <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                      <label class="form-check-label" for="terms">
                        Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a> dan <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Kebijakan Privasi</a> Irvana Buah
                      </label>
                    </div>
                    <div class="place-order-container">
                      <button type="submit" class="btn btn-primary place-order-btn w-100">
                        <i class="bi bi-bag-check me-2"></i>
                        <span class="btn-text">Buat Pesanan</span>
                        <span class="btn-price ms-2">- Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <!-- Order Summary -->
              <div class="order-summary" data-aos="fade-left" data-aos-delay="200">
                <div class="order-summary-header">
                  <h3>Ringkasan Pesanan</h3>
                  <span class="item-count">{{ $cartItems->count() }} Item</span>
                </div>

                <div class="order-summary-content">
                  <div class="order-items">
                    @foreach($cartItems as $item)
                    <div class="order-item">
                      <div class="order-item-image">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid"
                             onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
                      </div>
                      <div class="order-item-details">
                        <h4>{{ $item->product->name }}</h4>
                        <p class="order-item-variant text-muted">{{ $item->product->category->name ?? '' }}</p>
                        <div class="order-item-price">
                          <span class="quantity">{{ $item->quantity }} ×</span>
                          <span class="price">Rp {{ number_format($item->product->effective_price, 0, ',', '.') }}</span>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>

                  {{-- Poin Loyalitas --}}
                  @auth
                  @php $userPoints = \App\Services\PointsService::class; @endphp
                  @php $pointsBal = app(\App\Services\PointsService::class)->getBalance(Auth::id()); @endphp
                  @if($pointsBal > 0)
                  <div class="points-section mb-3" style="padding:12px;background:#f0fdf4;border-radius:12px;border:1px dashed #86efac;">
                    <div style="font-size:.8rem;font-weight:700;color:#064e3b;margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em;">
                      <i class="bi bi-star-fill me-1" style="color:#f59e0b;"></i>Tukar Poin
                      <span style="font-weight:400;color:#059669;margin-left:6px;">Saldo: <strong>{{ number_format($pointsBal) }} poin</strong></span>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                      <input type="number" id="redeemPointsInput"
                             placeholder="Jumlah poin (maks {{ $pointsBal }})"
                             min="1" max="{{ $pointsBal }}" step="1"
                             style="flex:1;padding:8px 12px;border:1.5px solid #bbf7d0;border-radius:8px;font-size:.85rem;">
                      <button type="button" id="applyPointsBtn"
                              style="padding:8px 16px;background:#059669;color:#fff;border:none;border-radius:8px;font-size:.82rem;font-weight:700;cursor:pointer;">
                        Tukar
                      </button>
                    </div>
                    <div id="pointsMsg" style="font-size:.78rem;margin-top:6px;display:none;"></div>
                    <input type="hidden" name="redeem_points" id="redeemPointsHidden" value="0">
                  </div>
                  @endif
                  @endauth

                  {{-- Coupon Input --}}
                  <div class="coupon-section mb-3" style="padding:12px;background:#f8fafc;border-radius:12px;border:1px dashed #cbd5e1;">
                    <div style="font-size:.8rem;font-weight:700;color:#64748b;margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em;">
                      <i class="bi bi-tag-fill me-1" style="color:#0a4db8;"></i>Kode Kupon
                    </div>
                    <div class="d-flex gap-2" id="couponInputRow">
                      <input type="text" id="couponInput" placeholder="Masukkan kode kupon..."
                             style="flex:1;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.85rem;text-transform:uppercase;"
                             maxlength="50">
                      <button type="button" id="applyCouponBtn"
                              style="padding:8px 16px;background:#0a4db8;color:#fff;border:none;border-radius:8px;font-size:.82rem;font-weight:700;cursor:pointer;transition:opacity .2s;">
                        Pakai
                      </button>
                    </div>
                    <div id="couponMsg" style="font-size:.8rem;margin-top:6px;display:none;"></div>
                    <input type="hidden" name="coupon_code" id="couponCodeInput">
                  </div>

                  <div class="order-totals">
                    <div class="order-subtotal d-flex justify-content-between">
                      <span>Subtotal</span>
                      <span id="displaySubtotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="order-discount d-flex justify-content-between text-success" id="discountRow" style="display:none!important;">
                      <span id="discountLabel">Diskon</span>
                      <span id="discountAmount">- Rp 0</span>
                    </div>
                    <div class="order-shipping d-flex justify-content-between">
                      <span>Ongkos Kirim</span>
                      <span class="text-success">Gratis</span>
                    </div>
                    <div class="order-total d-flex justify-content-between fw-bold">
                      <span>Total</span>
                      <span id="displayTotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                  </div>

                  <div class="secure-checkout mt-3">
                    <div class="secure-checkout-header">
                      <i class="bi bi-shield-lock"></i>
                      <span>Transaksi Aman & Terpercaya</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <!-- Terms Modal -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Syarat & Ketentuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6>1. Ketentuan Pemesanan</h6>
                <p>Dengan melakukan pemesanan di Irvana Buah, pelanggan menyetujui bahwa produk yang dipesan adalah buah segar dengan kualitas terjamin. Ketersediaan stok dapat berubah sewaktu-waktu.</p>
                <h6>2. Pengiriman</h6>
                <p>Pengiriman dilakukan dalam area kota dengan radius maksimal 20km. Estimasi pengiriman 1-3 jam setelah pesanan dikonfirmasi.</p>
                <h6>3. Pembayaran</h6>
                <p>Pembayaran wajib dilakukan sebelum atau saat barang diterima (COD). Bukti pembayaran harus dikirimkan untuk metode transfer.</p>
                <h6>4. Pengembalian</h6>
                <p>Kami menjamin kesegaran produk. Jika ada masalah kualitas, hubungi kami dalam 2 jam setelah penerimaan.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Mengerti</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Privacy Modal -->
        <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Kebijakan Privasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6>Data yang Dikumpulkan</h6>
                <p>Kami mengumpulkan nama, email, nomor telepon, dan alamat pengiriman untuk memproses pesanan Anda.</p>
                <h6>Penggunaan Data</h6>
                <p>Data hanya digunakan untuk keperluan pengiriman dan komunikasi terkait pesanan. Kami tidak menjual data ke pihak ketiga.</p>
                <h6>Keamanan</h6>
                <p>Data Anda dilindungi dengan enkripsi dan tidak akan dibagikan tanpa persetujuan Anda.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Mengerti</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

</main>
@endsection

@section('scripts')
<script>
function selectPayment(el, method) {
    document.querySelectorAll('.payment-option').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.payment-details').forEach(d => d.classList.add('d-none'));
    const details = document.getElementById(method + '-details');
    if(details) details.classList.remove('d-none');
}
</script>

<script>
(function() {
    // Points redeem
    const applyPointsBtn = document.getElementById('applyPointsBtn');
    const pointsInput    = document.getElementById('redeemPointsInput');
    const pointsHidden   = document.getElementById('redeemPointsHidden');
    const pointsMsg      = document.getElementById('pointsMsg');
    const CSRF           = document.querySelector('meta[name=csrf-token]')?.content || '';

    if (applyPointsBtn) {
        applyPointsBtn.addEventListener('click', function() {
            const pts = parseInt(pointsInput.value) || 0;
            if (pts <= 0) { showPointsMsg('Masukkan jumlah poin yang ingin ditukar.', 'error'); return; }

            fetch('{{ route("points.calculate") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ points: pts })
            })
            .then(r => r.json())
            .then(data => {
                if (data.points > 0) {
                    pointsHidden.value = data.points;
                    const discRow = document.getElementById('discountRow');
                    const discLbl = document.getElementById('discountLabel');
                    const discAmt = document.getElementById('discountAmount');
                    const totalEl = document.getElementById('displayTotal');
                    // Update total display
                    const currentTotal = parseFloat(totalEl.textContent.replace(/[^0-9]/g,''));
                    const newTotal = Math.max(0, currentTotal - data.rupiah);
                    if (discRow) { discRow.style.display = 'flex'; discLbl.textContent = 'Poin (' + data.points + ' poin)'; discAmt.textContent = '- Rp ' + data.rupiah.toLocaleString('id-ID'); }
                    if (totalEl) totalEl.textContent = 'Rp ' + newTotal.toLocaleString('id-ID');
                    applyPointsBtn.textContent = '✓';
                    applyPointsBtn.style.background = '#064e3b';
                    pointsInput.readOnly = true;
                    showPointsMsg('✓ ' + data.points + ' poin ditukar → diskon ' + data.display, 'success');
                }
            })
            .catch(() => showPointsMsg('Gagal menukar poin.', 'error'));
        });
    }

    function showPointsMsg(text, type) {
        if (!pointsMsg) return;
        pointsMsg.textContent = text;
        pointsMsg.style.color = type === 'success' ? '#059669' : '#dc2626';
        pointsMsg.style.display = 'block';
    }
})();

(function() {
    const applyBtn   = document.getElementById('applyCouponBtn');
    const input      = document.getElementById('couponInput');
    const codeHidden = document.getElementById('couponCodeInput');
    const msg        = document.getElementById('couponMsg');
    const discRow    = document.getElementById('discountRow');
    const discAmt    = document.getElementById('discountAmount');
    const discLbl    = document.getElementById('discountLabel');
    const totalEl    = document.getElementById('displayTotal');
    const CSRF       = document.querySelector('meta[name=csrf-token]')?.content || '';

    if (!applyBtn) return;

    applyBtn.addEventListener('click', function() {
        const code = input.value.trim().toUpperCase();
        if (!code) { showMsg('Masukkan kode kupon terlebih dahulu.', 'error'); return; }

        applyBtn.disabled = true;
        applyBtn.textContent = '...';

        fetch('{{ route("coupon.apply") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ code })
        })
        .then(r => r.json())
        .then(data => {
            applyBtn.disabled = false;
            if (data.success) {
                showMsg('✓ ' + data.message, 'success');
                codeHidden.value = data.coupon_code;
                discRow.style.display = 'flex';
                discLbl.textContent   = 'Diskon (' + data.coupon_code + ')';
                discAmt.textContent   = '- ' + data.discount_display;
                totalEl.textContent   = data.total_display;
                applyBtn.textContent  = '✓';
                applyBtn.style.background = '#059669';
                input.readOnly = true;
            } else {
                showMsg('✗ ' + data.message, 'error');
                applyBtn.textContent = 'Pakai';
                codeHidden.value = '';
            }
        })
        .catch(() => {
            applyBtn.disabled = false;
            applyBtn.textContent = 'Pakai';
            showMsg('Terjadi kesalahan. Coba lagi.', 'error');
        });
    });

    input.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); applyBtn.click(); } });

    function showMsg(text, type) {
        msg.textContent = text;
        msg.style.color = type === 'success' ? '#059669' : '#dc2626';
        msg.style.display = 'block';
    }
})();
</script>

@endsection
