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
        $statusVal = $order->status instanceof \BackedEnum ? $order->status->value : (string) $order->status;
        $s        = $statusMap[$statusVal] ?? ['class'=>'bg-secondary text-white','icon'=>'bi-question','label'=>ucfirst($statusVal)];
        $payVal    = $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string) $order->payment_status;
        $paid     = $payVal === 'paid';
        $payLabel = $paid ? 'Lunas' : ($payVal === 'pending' ? 'Belum Bayar' : 'Gagal');
        $payClass = $paid ? 'bg-success text-white' : ($payVal === 'pending' ? 'bg-warning text-dark' : 'bg-danger text-white');
        $methodMap = ['bank_transfer' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cash' => 'COD (Bayar di Tempat)'];
        $methodVal = $order->payment_method instanceof \BackedEnum ? $order->payment_method->value : (string) $order->payment_method;
      @endphp

      <div class="row g-4">
        {{-- Left column --}}
        <div class="col-lg-8">
          {{-- Order header --}}
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
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

              {{-- Visual tracking timeline --}}
              @if($statusVal !== 'cancelled')
              @php
                $steps = [
                  ['key'=>'pending',    'icon'=>'bi-clock-fill',        'label'=>'Pesanan Masuk',    'sub'=>'Menunggu konfirmasi admin'],
                  ['key'=>'processing', 'icon'=>'bi-gear-fill',         'label'=>'Diproses',         'sub'=>'Pesanan sedang disiapkan'],
                  ['key'=>'shipped',    'icon'=>'bi-truck',             'label'=>'Dikirim',          'sub'=>'Dalam perjalanan ke Anda'],
                  ['key'=>'delivered',  'icon'=>'bi-check-circle-fill', 'label'=>'Selesai',          'sub'=>'Pesanan telah diterima'],
                ];
                $order_map = ['pending'=>0, 'processing'=>1, 'shipped'=>2, 'delivered'=>3];
                $currentStep = $order_map[$statusVal] ?? 0;
              @endphp
              <div class="order-tracking-timeline">
                @foreach($steps as $i => $step)
                  @php
                    $done   = $i < $currentStep;
                    $active = $i === $currentStep;
                  @endphp
                  <div class="ott-step {{ $done ? 'done' : ($active ? 'active' : '') }}">
                    <div class="ott-circle">
                      <i class="bi {{ $step['icon'] }}"></i>
                      @if($done)<span class="ott-check"><i class="bi bi-check-lg"></i></span>@endif
                    </div>
                    <div class="ott-label">{{ $step['label'] }}</div>
                    <div class="ott-sub">{{ $step['sub'] }}</div>
                    @if(!$loop->last)<div class="ott-line"></div>@endif
                  </div>
                @endforeach
              </div>
              @endif
            </div>
          </div>

          {{-- ── Visual Order Tracking ── --}}
          @php
            $steps = [
              ['key'=>'pending',    'icon'=>'bi-clock-fill',        'label'=>'Pesanan Dibuat',   'desc'=>'Pesanan diterima, menunggu konfirmasi'],
              ['key'=>'processing', 'icon'=>'bi-gear-fill',         'label'=>'Sedang Diproses',  'desc'=>'Pesanan sedang disiapkan oleh tim kami'],
              ['key'=>'shipped',    'icon'=>'bi-truck',             'label'=>'Dalam Pengiriman', 'desc'=>'Pesanan sedang dalam perjalanan ke Anda'],
              ['key'=>'delivered',  'icon'=>'bi-check-circle-fill', 'label'=>'Selesai',          'desc'=>'Pesanan telah diterima'],
            ];
            $flow   = ['pending'=>0,'processing'=>1,'shipped'=>2,'delivered'=>3];
            $curIdx = $statusVal === 'cancelled' ? -1 : ($flow[$statusVal] ?? 0);
          @endphp

          @if($statusVal !== 'cancelled')
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body px-4 py-4">
              <h6 class="fw-bold mb-4"><i class="bi bi-pin-map me-2" style="color:var(--accent-color)"></i>Status Pengiriman</h6>
              <div class="order-track-wrap">
                @foreach($steps as $i => $step)
                  @php
                    $done   = $i < $curIdx;
                    $active = $i === $curIdx;
                    $cls    = $done ? 'trk-done' : ($active ? 'trk-active' : 'trk-pending');
                  @endphp
                  <div class="trk-step {{ $cls }}">
                    <div class="trk-icon-wrap">
                      <div class="trk-icon"><i class="bi {{ $step['icon'] }}"></i></div>
                      @if(!$loop->last)<div class="trk-line"></div>@endif
                    </div>
                    <div class="trk-body">
                      <div class="trk-label">{{ $step['label'] }}</div>
                      <div class="trk-desc">{{ $step['desc'] }}</div>
                      @if($active)
                        <div class="trk-time"><i class="bi bi-clock me-1"></i>{{ $order->updated_at->format('d M Y, H:i') }} WIB</div>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          @else
          <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-left:4px solid #ef4444 !important;">
            <div class="card-body px-4 py-3 d-flex align-items-center gap-3">
              <div style="width:44px;height:44px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-x-circle-fill" style="color:#ef4444;font-size:1.2rem;"></i>
              </div>
              <div>
                <div class="fw-bold text-danger">Pesanan Dibatalkan</div>
                <div class="text-muted small">Pesanan ini telah dibatalkan pada {{ $order->updated_at->format('d M Y') }}</div>
              </div>
            </div>
          </div>
          @endif

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
                  @if($statusVal === 'delivered' && $item->product)
                    @php
                      $reviewed = \App\Models\Review::where('user_id', auth()->id())
                          ->where('product_id', $item->product_id)
                          ->where('order_id', $order->id)->exists();
                    @endphp
                    @if($reviewed)
                      <span class="badge bg-success-subtle text-success mt-1"><i class="bi bi-check-circle me-1"></i>Sudah diulas</span>
                    @else
                      <a href="{{ route('review.create', ['order_id'=>$order->id, 'product_id'=>$item->product_id]) }}"
                         class="badge mt-1" style="background:#eaf0fc;color:#0a4db8;text-decoration:none;">
                        <i class="bi bi-star me-1"></i>Tulis Ulasan
                      </a>
                    @endif
                  @endif
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
                <span class="fw-semibold">{{ $methodMap[$methodVal] ?? $methodVal }}</span>
              </div>
              @if($methodVal === 'bank_transfer' && !$paid)
              <div class="alert alert-warning rounded-3 small mt-3 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                Silakan transfer ke:<br>
                <strong>BCA</strong> 1234567890 a/n Irvana Buah<br>
                <strong>Mandiri</strong> 0987654321 a/n Irvana Buah<br>
                Sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
              </div>
              @elseif($methodVal === 'e_wallet' && !$paid)
              <div class="alert alert-info rounded-3 small mt-3 mb-0">
                <i class="bi bi-phone me-1"></i>
                Kirim ke nomor:<br>
                <strong>GoPay / OVO:</strong> 0812-3456-7890<br>
                Sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
              </div>
              @elseif($methodVal === 'cash')
              <div class="alert alert-secondary rounded-3 small mt-3 mb-0">
                <i class="bi bi-cash me-1"></i>Bayar langsung saat pesanan tiba.
              </div>
              @endif
            </div>
          </div>

          <div class="d-grid">
            <a href="{{ route('products') }}" class="btn btn-irvana btn-irvana-lg">
              <i class="bi bi-shop me-2"></i>Belanja Lagi
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
