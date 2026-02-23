@extends('home.app')

@section('title', 'Pesanan Berhasil - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container">
        <h1 class="mb-0">Pesanan Berhasil! 🎉</h1>
      </div>
    </div>

    <section class="section">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card border-0 shadow-sm text-center p-5">
              <div class="mb-4">
                <div class="mx-auto mb-3" style="width:80px;height:80px;background:#d4edda;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                  <i class="bi bi-check-lg text-success" style="font-size:2.5rem;"></i>
                </div>
                <h2 class="text-success">Terima Kasih!</h2>
                <p class="text-muted fs-5">Pesanan Anda berhasil dibuat</p>
              </div>

              <div class="bg-light rounded-3 p-4 mb-4 text-start">
                <div class="row g-3">
                  <div class="col-md-6">
                    <p class="mb-1 text-muted small">Nomor Pesanan</p>
                    <strong>{{ $order->order_number }}</strong>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 text-muted small">Tanggal</p>
                    <strong>{{ $order->created_at->format('d M Y, H:i') }} WIB</strong>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 text-muted small">Total Pembayaran</p>
                    <strong class="text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1 text-muted small">Metode Pembayaran</p>
                    <strong>
                      @switch($order->payment_method)
                        @case('bank_transfer') Transfer Bank @break
                        @case('e_wallet') Dompet Digital @break
                        @case('cash') COD / Bayar di Tempat @break
                        @default {{ $order->payment_method }}
                      @endswitch
                    </strong>
                  </div>
                  <div class="col-12">
                    <p class="mb-1 text-muted small">Alamat Pengiriman</p>
                    <strong>{{ $order->shipping_address }}</strong>
                  </div>
                </div>
              </div>

              <!-- Items -->
              <div class="text-start mb-4">
                <h6 class="fw-bold mb-3">Item Pesanan:</h6>
                @foreach($order->orderItems as $item)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                  <div class="d-flex align-items-center gap-3">
                    <img src="{{ $item->product->image_url }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;" 
                         onerror="this.src='{{ asset('assets/img/fruits/default-fruit.webp') }}'">
                    <div>
                      <p class="mb-0 fw-semibold">{{ $item->product->name }}</p>
                      <small class="text-muted">{{ $item->quantity }} kg × Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                  </div>
                  <strong>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
                </div>
                @endforeach
                <div class="d-flex justify-content-between pt-3">
                  <strong>Total</strong>
                  <strong class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </div>
              </div>

              @if($order->payment_method === 'bank_transfer')
              <div class="alert alert-info text-start">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi Pembayaran</h6>
                <p class="mb-1">Transfer ke rekening berikut:</p>
                <ul class="mb-2">
                  <li>BCA: <strong>1234567890</strong> a/n Irvana Buah</li>
                  <li>Mandiri: <strong>0987654321</strong> a/n Irvana Buah</li>
                </ul>
                <p class="mb-0">Konfirmasi via WhatsApp: <strong>+62 812-3456-7890</strong> dengan menyertakan nomor pesanan <strong>{{ $order->order_number }}</strong></p>
              </div>
              @elseif($order->payment_method === 'e_wallet')
              <div class="alert alert-info text-start">
                <h6><i class="bi bi-phone me-2"></i>Informasi Pembayaran Digital</h6>
                <p class="mb-1">Transfer ke dompet digital:</p>
                <p class="mb-0">GoPay/OVO: <strong>0812-3456-7890</strong> a/n Irvana Buah<br>
                Kirim bukti via WhatsApp: <strong>+62 812-3456-7890</strong></p>
              </div>
              @else
              <div class="alert alert-success text-start">
                <h6><i class="bi bi-cash-coin me-2"></i>Pembayaran COD</h6>
                <p class="mb-0">Siapkan uang tunai Rp {{ number_format($order->total_amount, 0, ',', '.') }} saat kurir tiba.<br>
                Estimasi pengiriman: 1-3 jam setelah pesanan dikonfirmasi.</p>
              </div>
              @endif

              <div class="d-flex gap-3 justify-content-center mt-3">
                <a href="{{ route('home') }}" class="btn btn-primary">
                  <i class="bi bi-house me-1"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                  <i class="bi bi-bag-check me-1"></i> Lihat Pesanan Saya
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
