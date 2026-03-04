@extends('home.app')
@section('title', 'Tulis Ulasan - Irvana Buah')
@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Tulis Ulasan</h1>
      <nav class="breadcrumbs"><ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('customer.orders') }}">Pesanan</a></li>
        <li class="current">Ulasan</li>
      </ol></nav>
    </div>
  </div>

  <section class="section py-5">
    <div class="container" style="max-width:640px;">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- Product header --}}
        <div style="background:linear-gradient(135deg,#0a4db8,#1e3a8a);padding:28px 28px 20px;">
          <div class="d-flex align-items-center gap-3">
            <img src="{{ optional($orderItem->product)->image_url }}"
                 onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'"
                 style="width:64px;height:64px;object-fit:cover;border-radius:12px;border:2px solid rgba(255,255,255,.3);">
            <div>
              <div style="color:#a5c0f7;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Ulasan Produk</div>
              <div style="color:#fff;font-size:1.05rem;font-weight:700;margin-top:2px;">{{ optional($orderItem->product)->name }}</div>
              <div style="color:#93b8f0;font-size:.82rem;margin-top:2px;">Pesanan #{{ $order->order_number }}</div>
            </div>
          </div>
        </div>

        <div class="card-body p-4">
          @if($existing)
          <div class="alert alert-info rounded-3 mb-4">
            <i class="bi bi-info-circle me-2"></i>Anda sudah memberikan ulasan sebelumnya. Form ini akan memperbarui ulasan Anda.
          </div>
          @endif

          <form action="{{ route('review.store') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id"   value="{{ $order->id }}">
            <input type="hidden" name="product_id" value="{{ $orderItem->product_id }}">

            {{-- Star rating --}}
            <div class="mb-4">
              <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
              <div class="d-flex gap-2 align-items-center" id="starRatingContainer">
                @for($i = 1; $i <= 5; $i++)
                  <button type="button" class="star-btn" data-value="{{ $i }}"
                          style="background:none;border:none;font-size:2.2rem;color:#d1d5db;cursor:pointer;transition:color .15s,transform .15s;line-height:1;">
                    ★
                  </button>
                @endfor
                <span id="starLabel" style="margin-left:8px;font-size:.88rem;color:#94a3b8;font-weight:500;"></span>
              </div>
              <input type="hidden" name="rating" id="ratingInput" value="{{ $existing?->rating }}">
              @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            {{-- Title --}}
            <div class="mb-3">
              <label class="form-label fw-semibold">Judul Ulasan <span class="text-muted fw-normal">(opsional)</span></label>
              <input type="text" name="title" class="form-control rounded-3" maxlength="100"
                     placeholder="Ringkas pendapat Anda dalam satu kalimat..."
                     value="{{ old('title', $existing?->title) }}">
            </div>

            {{-- Body --}}
            <div class="mb-4">
              <label class="form-label fw-semibold">Ceritakan Pengalaman Anda <span class="text-muted fw-normal">(opsional)</span></label>
              <textarea name="body" class="form-control rounded-3" rows="4" maxlength="1000"
                        placeholder="Bagaimana kualitas, rasa, atau kesegaran buah ini?...">{{ old('body', $existing?->body) }}</textarea>
              <div class="text-end mt-1"><small class="text-muted" id="bodyCount">0/1000</small></div>
            </div>

            <div class="d-flex gap-3">
              <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-secondary rounded-pill flex-grow-1">
                Batal
              </a>
              <button type="submit" class="btn-irvana flex-grow-1">
                <i class="bi bi-star me-2"></i>{{ $existing ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>

<style>
.star-btn:hover, .star-btn.active { color: #f59e0b !important; transform: scale(1.15); }
</style>
<script>
(function() {
    const stars  = document.querySelectorAll('.star-btn');
    const input  = document.getElementById('ratingInput');
    const label  = document.getElementById('starLabel');
    const labels = ['', 'Sangat Buruk 😞', 'Kurang Baik 😐', 'Cukup Baik 🙂', 'Bagus 😊', 'Luar Biasa! 🤩'];
    let current  = parseInt(input.value) || 0;

    function paint(n) {
        stars.forEach((s, i) => {
            s.style.color = i < n ? '#f59e0b' : '#d1d5db';
            s.classList.toggle('active', i < n);
        });
        label.textContent = labels[n] || '';
    }
    paint(current);

    stars.forEach(s => {
        s.addEventListener('mouseenter', () => paint(+s.dataset.value));
        s.addEventListener('mouseleave', () => paint(current));
        s.addEventListener('click', () => {
            current = +s.dataset.value;
            input.value = current;
            paint(current);
        });
    });

    const body  = document.querySelector('[name=body]');
    const count = document.getElementById('bodyCount');
    if (body) {
        count.textContent = body.value.length + '/1000';
        body.addEventListener('input', () => count.textContent = body.value.length + '/1000');
    }
})();
</script>
@endsection
