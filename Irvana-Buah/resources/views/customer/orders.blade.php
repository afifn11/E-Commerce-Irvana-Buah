@extends('home.app')
@section('title', 'Pesanan Saya - Irvana Buah')

@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Pesanan Saya</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li class="current">Pesanan Saya</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="section py-5">
    <div class="container" data-aos="fade-up">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($orders->isEmpty())
        <div class="text-center py-5">
          <div style="font-size:5rem; color:#dee2e6;"><i class="bi bi-bag-x"></i></div>
          <h4 class="mt-3 text-muted">Belum ada pesanan</h4>
          <p class="text-muted">Yuk mulai belanja buah segar berkualitas!</p>
          <a href="{{ route('products') }}" class="btn btn-success btn-lg px-4 mt-2">
            <i class="bi bi-shop me-2"></i>Mulai Belanja
          </a>
        </div>
      @else
        <div class="d-flex flex-column gap-4">
          @foreach($orders as $order)
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
          @endphp
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4">
              <div class="row align-items-center g-2">
                <div class="col-md-7">
                  <p class="mb-0 text-muted small"><i class="bi bi-receipt me-1"></i>No. Pesanan</p>
                  <h6 class="mb-0 fw-bold">{{ $order->order_number }}</h6>
                  <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y, H:i') }} WIB</small>
                </div>
                <div class="col-md-5 text-md-end">
                  <span class="badge {{ $s['class'] }} rounded-pill px-3 py-2 me-1 mb-1">
                    <i class="bi {{ $s['icon'] }} me-1"></i>{{ $s['label'] }}
                  </span>
                  <span class="badge {{ $payClass }} rounded-pill px-3 py-2 mb-1">{{ $payLabel }}</span>
                </div>
              </div>
            </div>

            <div class="card-body px-4 py-3">
              <div class="d-flex flex-wrap gap-3">
                @foreach($order->orderItems->take(3) as $item)
                <div class="d-flex align-items-center gap-2">
                  <img src="{{ optional($item->product)->image_url ?? asset('assets/img/fruits/default-fruit.webp') }}"
                       onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'"
                       style="width:52px;height:52px;object-fit:cover;border-radius:10px;border:1px solid #eee;">
                  <div>
                    <div class="small fw-semibold" style="max-width:130px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                      {{ optional($item->product)->name ?? 'Produk dihapus' }}
                    </div>
                    <div class="small text-muted">{{ $item->quantity }} kg × Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                  </div>
                </div>
                @endforeach
                @if($order->orderItems->count() > 3)
                  <div class="d-flex align-items-center">
                    <span class="badge bg-light text-dark border px-3 py-2">+{{ $order->orderItems->count() - 3 }} item lainnya</span>
                  </div>
                @endif
              </div>
            </div>

            <div class="card-footer bg-white border-top px-4 py-3">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                  <span class="text-muted small d-block">Total Pembayaran</span>
                  <span class="fw-bold fs-5" style="color: var(--accent-color)">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-success px-4 rounded-pill">
                  <i class="bi bi-eye me-1"></i>Lihat Detail
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>
      @endif
    </div>
  </section>
</main>
@endsection
