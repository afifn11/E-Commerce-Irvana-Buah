<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Pesanan - Irvana Buah</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:40px 16px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;border-radius:20px;overflow:hidden;box-shadow:0 8px 40px rgba(0,0,0,0.12);">

      {{-- ═══ HERO HEADER dengan background buah ═══ --}}
      <tr><td style="padding:0;position:relative;">
        <div style="
          background-image: url('https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1200&q=80');
          background-size: cover;
          background-position: center;
          position: relative;
          min-height: 220px;
          display: block;
        ">
          {{-- Overlay gelap agar teks terbaca --}}
          <div style="
            background: linear-gradient(135deg, rgba(10,40,100,0.82) 0%, rgba(5,20,60,0.75) 100%);
            padding: 44px 40px 36px;
            text-align: center;
            min-height: 220px;
            box-sizing: border-box;
          ">
            {{-- Logo / Brand --}}
            <div style="margin-bottom:20px;">
              <div style="
                display:inline-block;
                background:rgba(255,255,255,0.15);
                border:1.5px solid rgba(255,255,255,0.3);
                border-radius:12px;
                padding:8px 20px;
              ">
                <span style="color:#fff;font-size:1.1rem;font-weight:800;letter-spacing:1px;">IRVANA BUAH</span>
              </div>
            </div>

            {{-- Judul --}}
            <div style="color:#fff;font-size:1.6rem;font-weight:800;letter-spacing:-0.5px;margin-bottom:6px;line-height:1.2;">
              Update Status Pesanan
            </div>
            <div style="color:rgba(200,220,255,0.85);font-size:0.88rem;letter-spacing:0.3px;">
              Toko Buah Segar Online Terpercaya
            </div>

            {{-- Status Badge --}}
            <div style="margin-top:24px;">
              <span style="
                display:inline-block;
                background:{{ $statusColor }};
                color:#fff;
                font-weight:700;
                font-size:0.95rem;
                padding:10px 32px;
                border-radius:999px;
                letter-spacing:0.3px;
                box-shadow:0 4px 16px rgba(0,0,0,0.25);
              ">
                {{ $statusLabel }}
              </span>
            </div>
          </div>
        </div>
      </td></tr>

      {{-- ═══ GREETING ═══ --}}
      <tr><td style="background:#fff;padding:32px 40px 0;">
        <p style="margin:0 0 8px;color:#94a3b8;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Halo,</p>
        <h2 style="margin:0 0 12px;color:#1e293b;font-size:1.25rem;font-weight:800;">{{ $order->user->name }}</h2>
        <p style="margin:0;color:#475569;font-size:0.95rem;line-height:1.7;padding-bottom:24px;border-bottom:1px solid #f1f5f9;">
          {{ $statusMessage }}
        </p>
      </td></tr>

      {{-- ═══ ORDER INFO CARDS ═══ --}}
      <tr><td style="background:#fff;padding:24px 40px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-radius:14px;overflow:hidden;border:1px solid #e2e8f0;">
          <tr>
            <td width="50%" style="padding:18px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;">
              <div style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:5px;">No. Pesanan</div>
              <div style="color:#1e293b;font-weight:800;font-size:1rem;font-family:monospace;">{{ $order->order_number }}</div>
            </td>
            <td width="50%" style="padding:18px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;border-left:1px solid #e2e8f0;">
              <div style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:5px;">Tanggal Pesan</div>
              <div style="color:#1e293b;font-weight:600;font-size:0.9rem;">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </td>
          </tr>
          <tr>
            <td width="50%" style="padding:18px 20px;background:#fff;">
              <div style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:5px;">Total Pembayaran</div>
              <div style="color:#0a4db8;font-weight:800;font-size:1.15rem;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </td>
            <td width="50%" style="padding:18px 20px;background:#fff;border-left:1px solid #e2e8f0;">
              <div style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:5px;">Status Terkini</div>
              <div style="display:inline-block;background:{{ $statusColor }}18;color:{{ $statusColor }};font-weight:700;font-size:0.82rem;padding:4px 12px;border-radius:999px;border:1px solid {{ $statusColor }}40;">
                {{ $statusLabel }}
              </div>
            </td>
          </tr>
        </table>
      </td></tr>

      {{-- ═══ ORDER ITEMS ═══ --}}
      <tr><td style="background:#fff;padding:0 40px 24px;">
        <p style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 14px;">Ringkasan Pesanan</p>

        <table width="100%" cellpadding="0" cellspacing="0" style="border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
          {{-- Header row --}}
          <tr style="background:#f8fafc;">
            <td style="padding:10px 16px;color:#64748b;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Produk</td>
            <td style="padding:10px 16px;color:#64748b;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;text-align:center;">Qty</td>
            <td style="padding:10px 16px;color:#64748b;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;text-align:right;">Harga</td>
          </tr>

          @foreach($order->orderItems->take(5) as $index => $item)
          <tr style="background:{{ $index % 2 === 0 ? '#fff' : '#fafbfc' }};">
            <td style="padding:12px 16px;color:#1e293b;font-size:0.88rem;font-weight:600;border-top:1px solid #f1f5f9;">
              {{ optional($item->product)->name ?? 'Produk' }}
            </td>
            <td style="padding:12px 16px;color:#64748b;font-size:0.88rem;text-align:center;border-top:1px solid #f1f5f9;">
              {{ $item->quantity }}
            </td>
            <td style="padding:12px 16px;color:#1e293b;font-size:0.88rem;font-weight:600;text-align:right;border-top:1px solid #f1f5f9;white-space:nowrap;">
              Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
            </td>
          </tr>
          @endforeach

          @if($order->orderItems->count() > 5)
          <tr style="background:#f8fafc;">
            <td colspan="3" style="padding:10px 16px;color:#94a3b8;font-size:0.8rem;border-top:1px solid #f1f5f9;">
              + {{ $order->orderItems->count() - 5 }} item lainnya
            </td>
          </tr>
          @endif

          {{-- Total row --}}
          <tr style="background:#0a4db8;">
            <td colspan="2" style="padding:14px 16px;color:rgba(255,255,255,0.85);font-size:0.82rem;font-weight:600;">Total Pembayaran</td>
            <td style="padding:14px 16px;color:#fff;font-size:1rem;font-weight:800;text-align:right;white-space:nowrap;">
              Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </td>
          </tr>
        </table>
      </td></tr>

      {{-- ═══ STATUS TIMELINE ═══ --}}
      @php
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];
        $statusLabels = ['Diterima', 'Diproses', 'Dikirim', 'Selesai'];
        $statusVal = $order->status instanceof \BackedEnum ? $order->status->value : (string) $order->status;
        $currentIndex = array_search($statusVal, $statuses);
      @endphp
      @if($statusVal !== 'cancelled')
      <tr><td style="background:#fff;padding:0 40px 28px;">
        <p style="color:#94a3b8;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 20px;">Tracking Pesanan</p>
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            @foreach($statuses as $i => $s)
            @php $done = $currentIndex !== false && $i <= $currentIndex; @endphp
            <td style="text-align:center;vertical-align:top;padding:0 4px;">
              {{-- Circle --}}
              <div style="
                width:32px;height:32px;border-radius:50%;margin:0 auto 8px;
                background:{{ $done ? '#0a4db8' : '#e2e8f0' }};
                display:flex;align-items:center;justify-content:center;
                line-height:32px;
                font-size:0.75rem;font-weight:700;
                color:{{ $done ? '#fff' : '#94a3b8' }};
              ">{{ $i + 1 }}</div>
              {{-- Label --}}
              <div style="color:{{ $done ? '#1e293b' : '#94a3b8' }};font-size:0.72rem;font-weight:{{ $done ? '700' : '400' }};">
                {{ $statusLabels[$i] }}
              </div>
            </td>
            @if($i < count($statuses) - 1)
            <td style="vertical-align:top;padding-top:15px;">
              <div style="height:2px;background:{{ ($currentIndex !== false && $i < $currentIndex) ? '#0a4db8' : '#e2e8f0' }};"></div>
            </td>
            @endif
            @endforeach
          </tr>
        </table>
      </td></tr>
      @endif

      {{-- ═══ CTA BUTTON ═══ --}}
      <tr><td style="background:#fff;padding:0 40px 36px;text-align:center;">
        <a href="{{ route('customer.orders.show', $order->id) }}"
           style="
             display:inline-block;
             background:linear-gradient(135deg,#0a4db8,#1d6fe8);
             color:#fff;
             text-decoration:none;
             padding:15px 40px;
             border-radius:999px;
             font-weight:700;
             font-size:0.95rem;
             letter-spacing:0.2px;
             box-shadow:0 6px 20px rgba(10,77,184,0.4);
           ">
          Lihat Detail Pesanan
        </a>

        @if($statusVal === 'delivered')
        <div style="margin-top:16px;">
          <a href="{{ route('customer.orders.show', $order->id) }}"
             style="
               display:inline-block;
               border:2px solid #0a4db8;
               color:#0a4db8;
               text-decoration:none;
               padding:11px 32px;
               border-radius:999px;
               font-weight:600;
               font-size:0.88rem;
             ">
            Tulis Ulasan Produk
          </a>
        </div>
        @endif
      </td></tr>

      {{-- ═══ DIVIDER dengan buah kecil ═══ --}}
      <tr><td style="padding:0;">
        <div style="
          background-image: url('https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=1200&q=80');
          background-size: cover;
          background-position: center 60%;
          height: 80px;
          position: relative;
        ">
          <div style="background:linear-gradient(180deg, #fff 0%, rgba(10,40,100,0.6) 100%);height:80px;"></div>
        </div>
      </td></tr>

      {{-- ═══ FOOTER ═══ --}}
      <tr><td style="background:#0f172a;padding:28px 40px;text-align:center;border-radius:0 0 20px 20px;">
        <div style="color:#fff;font-size:1rem;font-weight:800;letter-spacing:1px;margin-bottom:6px;">IRVANA BUAH</div>
        <div style="color:#64748b;font-size:0.78rem;margin-bottom:16px;">Toko Buah Segar Online Terpercaya</div>

        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center">
              <a href="https://irvana-buah.up.railway.app" style="color:#60a5fa;text-decoration:none;font-size:0.8rem;margin:0 10px;">Website</a>
              <span style="color:#334155;">|</span>
              <a href="https://wa.me/6281234567890" style="color:#60a5fa;text-decoration:none;font-size:0.8rem;margin:0 10px;">WhatsApp</a>
              <span style="color:#334155;">|</span>
              <a href="mailto:info.irvanabuah@gmail.com" style="color:#60a5fa;text-decoration:none;font-size:0.8rem;margin:0 10px;">Email</a>
            </td>
          </tr>
        </table>

        <p style="color:#334155;font-size:0.75rem;margin:16px 0 0;">
          &copy; {{ date('Y') }} Irvana Buah. Semua hak dilindungi.<br>
          Email ini dikirim otomatis, mohon tidak membalas email ini.
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>

</body>
</html>