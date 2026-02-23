@extends('home.app')
@section('title', 'Detail Pesanan #' . $order->order_number . ' - Irvana Buah')

@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Detail Pesanan</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('customer.orders') }}">Pesanan Saya</a></li>
          <li class="current">{{ $order->order_number }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="section py-5">
    <div class="container" data-aos="fade-up">
      <div class="mb-4">
        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-arrow-left me-1"></i>Kembali ke Pesanan
        </a>
      </div>

      @php
        $statusMap = [
          'pending'    => ['class' => 'bg-warning text-dark',  'icon' => 'bi-clock',             'label' => 'Menunggu Konfirmasi'],
          'processing' => ['class' => 'bg-info text-white',    'icon' => 'bi-gear-fill',         'label' => 'Sedang Diproses'],
          'shipped'    => ['class' => 'bg-primary text-white', 'icon' => 'bi-truck',             'label' => 'Sedang Dikirim'],
          'delivered'  => ['class' => 'bg-success text-white', 'icon' => 'bi-check-circle-fill', 'label' => 'Selesai'],
          'cancelled'  => ['class' => 'bg-danger text-white',  'icon' => 'bi-x-circle-fill',    'label' => 'Dibatalkan'],
        ];
        $s        = $statusMap[$order->status] ?? ['class'=>'bg-secondary text-white','icon'=>'bi-question','label'=>ucfirst($order->status)];
        $paid     = $order->payment_status === 'paid';
        $payLabel = $paid ? 'Lunas' : ($order->payment_status === 'pending' ? 'Belum Bayar' : 'Gagal');
        $payClass = $paid ? 'bg-success text-white' : ($order->payment_status === 'pending' ? 'bg-warning text-dark' : 'bg-danger text-white');
        $methodMap = ['bank_transfer' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cash' => 'COD (Bayar di Tempat)'];
      @endphp

      <div class="row g-4">
        {{-- Left column --}}
        <div class="col-lg-8">
          {{-- Status card --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                  <p class="text-muted small mb-1"><i class="bi bi-receipt me-1"></i>No. Pesanan</p>
                  <h5 class="fw-bold mb-1">{{ $order->order_number }}</h5>
                  <p class="text-muted small mb-0"><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="text-end">
                  <span class="badge {{ $s['class'] }} rounded-pill px-4 py-2 fs-6">
                    <i class="bi {{ $s['icon'] }} me-2"></i>{{ $s['label'] }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          {{-- Items --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom px-4 py-3">
              <h6 class="fw-bold mb-0"><i class="bi bi-bag me-2" style="color:var(--accent-color)"></i>Item Pesanan</h6>
            </div>
            <div class="card-body p-0">
              @foreach($order->orderItems as $item)
              <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                <img src="{{ optional($item->product)->image_url ?? asset('assets/img/fruits/default-fruit.webp') }}"
                     onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'"
                     style="width:64px;height:64px;object-fit:cover;border-radius:12px;border:1px solid #eee;">
                <div class="flex-grow-1">
                  <div class="fw-semibold">{{ optional($item->product)->name ?? 'Produk dihapus' }}</div>
                  <div class="text-muted small">{{ $item->quantity }} kg × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                <div class="fw-bold text-end" style="min-width:100px">
                  Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                </div>
              </div>
              @endforeach
              <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-light rounded-bottom-4">
                <span class="fw-semibold">Total Pembayaran</span>
                <span class="fw-bold fs-5" style="color:var(--accent-color)">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>

          {{-- Shipping --}}
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom px-4 py-3">
              <h6 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2" style="color:var(--accent-color)"></i>Informasi Pengiriman</h6>
            </div>
            <div class="card-body px-4 py-3">
              <div class="row g-3">
                <div class="col-sm-6">
                  <p class="text-muted small mb-1">Nama Penerima</p>
                  <p class="fw-semibold mb-0">{{ $order->customer_name }}</p>
                </div>
                <div class="col-sm-6">
                  <p class="text-muted small mb-1">No. Telepon</p>
                  <p class="fw-semibold mb-0">{{ $order->customer_phone ?? '-' }}</p>
                </div>
                <div class="col-12">
                  <p class="text-muted small mb-1">Alamat Pengiriman</p>
                  <p class="fw-semibold mb-0">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="col-12">
                  <p class="text-muted small mb-1">Catatan</p>
                  <p class="mb-0 fst-italic text-muted">{{ $order->notes }}</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        {{-- Right column --}}
        <div class="col-lg-4">
          {{-- Payment info --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom px-4 py-3">
              <h6 class="fw-bold mb-0"><i class="bi bi-credit-card me-2" style="color:var(--accent-color)"></i>Informasi Pembayaran</h6>
            </div>
            <div class="card-body px-4 py-3">
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Status</span>
                <span class="badge {{ $payClass }} rounded-pill px-3 py-2">{{ $payLabel }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Metode</span>
                <span class="fw-semibold">{{ $methodMap[$order->payment_method] ?? $order->payment_method }}</span>
              </div>
              @if($order->payment_method === 'bank_transfer' && !$paid)
              <div class="alert alert-warning rounded-3 small mt-3 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Silakan transfer ke:<br>
                <strong>BCA</strong> 1234567890 a/n Irvana Buah<br>
                <strong>Mandiri</strong> 0987654321 a/n Irvana Buah<br>
                Sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
              </div>
              @elseif($order->payment_method === 'e_wallet' && !$paid)
              <div class="alert alert-info rounded-3 small mt-3 mb-0">
                <i class="bi bi-phone me-1"></i>
                Kirim ke nomor:<br>
                <strong>GoPay / OVO:</strong> 0812-3456-7890<br>
                Sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
              </div>
              @elseif($order->payment_method === 'cash')
              <div class="alert alert-secondary rounded-3 small mt-3 mb-0">
                <i class="bi bi-cash me-1"></i>Bayar langsung saat pesanan tiba.
              </div>
              @endif
            </div>
          </div>

          <div class="d-grid">
            <a href="{{ route('products') }}" class="btn btn-success btn-lg rounded-pill">
              <i class="bi bi-shop me-2"></i>Belanja Lagi
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
