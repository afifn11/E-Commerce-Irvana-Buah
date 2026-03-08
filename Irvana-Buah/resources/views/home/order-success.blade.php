@extends('home.app')

@section('title', 'Pesanan Berhasil - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container">
        <h1 class="mb-0" id="pageTitle">Pesanan Berhasil! 🎉</h1>
      </div>
    </div>

    <section class="section">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8">

            {{-- MIDTRANS: Waiting for payment --}}
            @php
              $methodVal = $order->payment_method instanceof \BackedEnum
                ? $order->payment_method->value
                : (string) $order->payment_method;
              $isMidtrans = $methodVal === 'midtrans';
              $isCOD      = $methodVal === 'cash';
              $isPaid     = in_array(
                $order->payment_status instanceof \BackedEnum
                  ? $order->payment_status->value
                  : (string) $order->payment_status,
                ['paid']
              );
            @endphp

            @if($isMidtrans && !$isPaid)
            {{-- Waiting for Snap payment --}}
            <div class="card border-0 shadow-sm text-center p-5 mb-4" id="awaitingPaymentCard">
              <div class="mb-4">
                <div class="mx-auto mb-3" style="width:80px;height:80px;background:#eaf0fc;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                  <i class="bi bi-credit-card-fill" style="font-size:2.2rem;color:#0a4db8;"></i>
                </div>
                <h2 style="color:#0a4db8;">Selesaikan Pembayaran</h2>
                <p class="text-muted">Pesanan <strong>#{{ $order->order_number }}</strong> berhasil dibuat.<br>Klik tombol di bawah untuk membayar.</p>
              </div>

              <div class="bg-light rounded-3 p-3 mb-4 text-start">
                <div class="d-flex justify-content-between">
                  <span class="text-muted">Total Pembayaran</span>
                  <strong class="text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </div>
              </div>

              <button id="payNowBtn" class="btn btn-primary btn-lg w-100 mb-3"
                      style="background:linear-gradient(135deg,#0a4db8,#1e3a8a);border:none;padding:16px;font-size:1.05rem;font-weight:700;border-radius:12px;">
                <i class="bi bi-credit-card-fill me-2"></i>Bayar Sekarang — Rp {{ number_format($order->total_amount, 0, ',', '.') }}
              </button>

              <div class="d-flex gap-2 justify-content-center flex-wrap mb-3 align-items-center">
                <i class="bi bi-shield-check-fill text-success"></i>
                <small class="text-muted">Transfer Bank · QRIS · GoPay · OVO · Dana · ShopeePay · Kartu Kredit</small>
              </div>

              <div class="text-center">
                <a href="{{ route('customer.orders') }}" class="text-muted small">
                  <i class="bi bi-clock me-1"></i>Bayar nanti di halaman pesanan saya
                </a>
              </div>
            </div>

            {{-- Payment confirmed (shown after Snap finish callback) --}}
            <div class="card border-0 shadow-sm text-center p-5 mb-4 d-none" id="paidCard">
              <div class="mb-3">
                <div class="mx-auto mb-3" style="width:80px;height:80px;background:#d4edda;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                  <i class="bi bi-check-lg text-success" style="font-size:2.5rem;"></i>
                </div>
                <h2 class="text-success">Pembayaran Berhasil!</h2>
                <p class="text-muted">Terima kasih, pesanan Anda sedang diproses.</p>
              </div>
            </div>

            @else
            {{-- COD or already paid --}}
            <div class="card border-0 shadow-sm text-center p-5 mb-4">
              <div class="mb-4">
                <div class="mx-auto mb-3" style="width:80px;height:80px;background:#d4edda;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                  <i class="bi bi-check-lg text-success" style="font-size:2.5rem;"></i>
                </div>
                <h2 class="text-success">Terima Kasih!</h2>
                <p class="text-muted fs-5">Pesanan Anda berhasil dibuat</p>
              </div>

              <div class="alert alert-success text-start">
                <h6><i class="bi bi-cash-coin me-2"></i>Pembayaran COD</h6>
                <p class="mb-0">Siapkan uang tunai <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> saat kurir tiba.<br>
                <small class="text-muted">Estimasi pengiriman: 1-3 jam setelah pesanan dikonfirmasi.</small></p>
              </div>
            </div>
            @endif

            {{-- Order detail card (always shown) --}}
            <div class="card border-0 shadow-sm p-4 mb-4">
              <h6 class="fw-bold mb-3"><i class="bi bi-receipt me-2" style="color:#0a4db8;"></i>Detail Pesanan #{{ $order->order_number }}</h6>

              <div class="row g-2 mb-3 text-sm">
                <div class="col-6">
                  <span class="text-muted small">Tanggal</span><br>
                  <strong>{{ $order->created_at->format('d M Y, H:i') }} WIB</strong>
                </div>
                <div class="col-6">
                  <span class="text-muted small">Alamat</span><br>
                  <strong>{{ $order->shipping_address }}</strong>
                </div>
              </div>

              @foreach($order->orderItems as $item)
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-flex align-items-center gap-3">
                  <img src="{{ optional($item->product)->image_url }}" style="width:46px;height:46px;object-fit:cover;border-radius:8px;"
                       onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
                  <div>
                    <p class="mb-0 fw-semibold" style="font-size:.9rem;">{{ optional($item->product)->name }}</p>
                    <small class="text-muted">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                  </div>
                </div>
                <strong>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
              </div>
              @endforeach

              @if($order->discount_amount > 0)
              <div class="d-flex justify-content-between pt-2 text-success">
                <span>Diskon</span>
                <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
              </div>
              @endif
              <div class="d-flex justify-content-between pt-2 fw-bold">
                <span>Total</span>
                <span class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
              </div>
            </div>

            {{-- Points earned --}}
            @if($order->points_earned > 0)
            <div class="mb-4" style="background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:16px;padding:18px 22px;display:flex;align-items:center;gap:14px;">
              <div style="font-size:2rem;">⭐</div>
              <div>
                <div style="font-weight:700;color:#92400e;">Anda mendapat poin belanja!</div>
                <div style="font-size:1.3rem;font-weight:900;color:#78350f;">+{{ number_format($order->points_earned) }} poin</div>
                <div style="font-size:.78rem;color:#92400e;margin-top:2px;">
                  Setara Rp {{ number_format($order->points_earned * 10) }} — <a href="{{ route('points.index') }}" style="color:#0a4db8;">Lihat poin saya</a>
                </div>
              </div>
            </div>
            @endif

            <div class="d-flex gap-3 justify-content-center">
              <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-house me-1"></i>Beranda
              </a>
              <a href="{{ route('customer.orders') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-bag-check me-1"></i>Pesanan Saya
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>
</main>
@endsection

@if($isMidtrans && !$isPaid)
@section('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
(function() {
    const orderId  = {{ $order->id }};
    const payBtn   = document.getElementById('payNowBtn');
    const CSRF     = document.querySelector('meta[name=csrf-token]').content;
    let snapToken  = null;

    // Auto-fetch snap token on load
    fetchToken();

    payBtn.addEventListener('click', function() {
        if (snapToken) {
            launchSnap(snapToken);
        } else {
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memuat...';
            fetchToken(true);
        }
    });

    function fetchToken(launch = false) {
        fetch(`/payment/snap/${orderId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="bi bi-credit-card-fill me-2"></i>Bayar Sekarang — Rp {{ number_format($order->total_amount, 0, ",", ".") }}';
            if (data.token) {
                snapToken = data.token;
                if (launch) launchSnap(snapToken);
            } else {
                alert(data.error || 'Gagal memuat pembayaran. Silakan coba lagi.');
            }
        })
        .catch(() => {
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="bi bi-credit-card-fill me-2"></i>Bayar Sekarang';
            alert('Koneksi bermasalah. Periksa internet Anda.');
        });
    }

    function launchSnap(token) {
        window.snap.pay(token, {
            onSuccess: function(result) {
                // Payment success
                document.getElementById('awaitingPaymentCard').classList.add('d-none');
                document.getElementById('paidCard').classList.remove('d-none');
                document.getElementById('pageTitle').textContent = 'Pembayaran Berhasil! ✅';
            },
            onPending: function(result) {
                alert('Pembayaran dalam proses. Kami akan update status pesanan Anda segera.');
                window.location.href = '{{ route("customer.orders.show", $order->id) }}';
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User closed popup without paying - just leave them on this page
                console.log('Snap popup ditutup');
            }
        });
    }
})();
</script>
@endsection
@endif
