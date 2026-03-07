@extends('home.app')
@section('title', 'Poin Saya - Irvana Buah')
@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">🎯 Poin Loyalitas</h1>
      <nav class="breadcrumbs"><ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="current">Poin Saya</li>
      </ol></nav>
    </div>
  </div>

  <section class="section py-5">
    <div class="container">
      <div class="row g-4">

        {{-- Balance Card --}}
        <div class="col-lg-4">
          <div class="card border-0 rounded-4 overflow-hidden h-100"
               style="background:linear-gradient(135deg,#0a4db8,#1e3a8a);">
            <div class="card-body p-4 text-white">
              <div style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#a5c0f7;margin-bottom:6px;">
                Total Poin Anda
              </div>
              <div style="font-size:3rem;font-weight:900;line-height:1.1;">
                {{ number_format($balance) }}
                <span style="font-size:1rem;font-weight:600;color:#a5c0f7;">poin</span>
              </div>
              <div style="font-size:.88rem;color:#93b8f0;margin-top:6px;">
                Setara dengan {{ $redeemValue }}
              </div>

              <hr style="border-color:rgba(255,255,255,.15);margin:20px 0;">

              <div class="row g-3 text-center">
                <div class="col-6">
                  <div style="font-size:1.3rem;font-weight:800;">{{ number_format($transactions->where('amount','>',0)->sum('amount')) }}</div>
                  <div style="font-size:.74rem;color:#93b8f0;">Total Diperoleh</div>
                </div>
                <div class="col-6">
                  <div style="font-size:1.3rem;font-weight:800;">{{ number_format(abs($transactions->where('amount','<',0)->sum('amount'))) }}</div>
                  <div style="font-size:.74rem;color:#93b8f0;">Total Ditukar</div>
                </div>
              </div>

              <div class="mt-4">
                <a href="{{ route('products') }}" class="btn w-100"
                   style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:10px;font-weight:600;backdrop-filter:blur(8px);">
                  <i class="bi bi-bag me-2"></i>Belanja & Kumpulkan Poin
                </a>
              </div>
            </div>
          </div>
        </div>

        {{-- Info + History --}}
        <div class="col-lg-8">

          {{-- How it works --}}
          <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
              <h6 class="fw-bold mb-3" style="font-family:'Sora',sans-serif;">
                <i class="bi bi-info-circle-fill me-2" style="color:#0a4db8;"></i>Cara Kerja Poin
              </h6>
              <div class="row g-3">
                <div class="col-sm-4">
                  <div style="background:#eaf0fc;border-radius:12px;padding:14px;text-align:center;">
                    <div style="font-size:1.6rem;margin-bottom:6px;">🛒</div>
                    <div style="font-size:.82rem;font-weight:700;color:#0a4db8;">Belanja</div>
                    <div style="font-size:.75rem;color:#64748b;margin-top:4px;">Setiap Rp 1.000 = <strong>1 poin</strong></div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div style="background:#d1fae5;border-radius:12px;padding:14px;text-align:center;">
                    <div style="font-size:1.6rem;margin-bottom:6px;">💰</div>
                    <div style="font-size:.82rem;font-weight:700;color:#059669;">Nilai Poin</div>
                    <div style="font-size:.75rem;color:#64748b;margin-top:4px;">1 poin = <strong>Rp 10</strong> diskon</div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div style="background:#fef3c7;border-radius:12px;padding:14px;text-align:center;">
                    <div style="font-size:1.6rem;margin-bottom:6px;">🏷️</div>
                    <div style="font-size:.82rem;font-weight:700;color:#d97706;">Tukarkan</div>
                    <div style="font-size:.75rem;color:#64748b;margin-top:4px;">Pakai saat <strong>checkout</strong></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Transaction history --}}
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom px-4 py-3">
              <h6 class="fw-bold mb-0" style="font-family:'Sora',sans-serif;">
                <i class="bi bi-clock-history me-2" style="color:#0a4db8;"></i>Riwayat Poin
              </h6>
            </div>
            <div class="card-body p-0">
              @if($transactions->isEmpty())
                <div class="text-center py-5" style="color:#94a3b8;">
                  <div style="font-size:2rem;margin-bottom:8px;">📋</div>
                  <p style="font-size:.88rem;">Belum ada riwayat poin.</p>
                  <a href="{{ route('products') }}" class="btn-irvana btn-irvana-sm mt-2">Mulai Belanja</a>
                </div>
              @else
                @foreach($transactions as $tx)
                <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #f1f5f9;">
                  <div style="width:40px;height:40px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:1.1rem;
                              background:{{ $tx->is_earn ? '#d1fae5' : '#fee2e2' }};">
                    {{ $tx->is_earn ? '⬆️' : '⬇️' }}
                  </div>
                  <div style="flex:1;min-width:0;">
                    <div style="font-size:.88rem;font-weight:600;color:#1e293b;">{{ $tx->description }}</div>
                    <div style="font-size:.75rem;color:#94a3b8;margin-top:2px;">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                  </div>
                  <div style="text-align:right;flex-shrink:0;">
                    <div style="font-size:.95rem;font-weight:800;color:{{ $tx->is_earn ? '#059669' : '#dc2626' }};">
                      {{ $tx->is_earn ? '+' : '' }}{{ number_format($tx->amount) }}
                    </div>
                    <div style="font-size:.73rem;color:#94a3b8;">saldo: {{ number_format($tx->balance_after) }}</div>
                  </div>
                </div>
                @endforeach
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</main>
@endsection
