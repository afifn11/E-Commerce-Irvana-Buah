<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Pesanan - Irvana Buah</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 16px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

      {{-- Header --}}
      <tr><td style="background:linear-gradient(135deg,#0a4db8,#1e3a8a);border-radius:16px 16px 0 0;padding:32px 40px;text-align:center;">
        <div style="font-size:2rem;margin-bottom:8px;">🍊</div>
        <div style="color:#fff;font-size:1.4rem;font-weight:800;letter-spacing:-.5px;">Irvana Buah</div>
        <div style="color:#a5c0f7;font-size:.85rem;margin-top:4px;">Update Status Pesanan</div>
      </td></tr>

      {{-- Status badge --}}
      <tr><td style="background:#fff;padding:32px 40px 0;text-align:center;">
        <div style="display:inline-block;background:{{ $statusColor }}1a;border:2px solid {{ $statusColor }};border-radius:999px;padding:10px 28px;color:{{ $statusColor }};font-weight:700;font-size:1rem;">
          {{ $statusLabel }}
        </div>
        <p style="color:#475569;margin:16px 0 0;font-size:.95rem;line-height:1.6;">{{ $statusMessage }}</p>
      </td></tr>

      {{-- Order info --}}
      <tr><td style="background:#fff;padding:24px 40px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
              <span style="color:#94a3b8;font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">No. Pesanan</span>
              <div style="color:#1e293b;font-weight:700;font-size:1rem;margin-top:4px;">{{ $order->order_number }}</div>
            </td>
            <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;border-left:1px solid #e2e8f0;">
              <span style="color:#94a3b8;font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Tanggal</span>
              <div style="color:#1e293b;font-weight:600;font-size:.9rem;margin-top:4px;">{{ $order->created_at->format('d M Y') }}</div>
            </td>
          </tr>
          <tr>
            <td style="padding:16px 20px;">
              <span style="color:#94a3b8;font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Total</span>
              <div style="color:#0a4db8;font-weight:800;font-size:1.1rem;margin-top:4px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </td>
            <td style="padding:16px 20px;border-left:1px solid #e2e8f0;">
              <span style="color:#94a3b8;font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Penerima</span>
              <div style="color:#1e293b;font-weight:600;font-size:.9rem;margin-top:4px;">{{ $order->user->name }}</div>
            </td>
          </tr>
        </table>
      </td></tr>

      {{-- Items --}}
      <tr><td style="background:#fff;padding:0 40px 24px;">
        <p style="color:#64748b;font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin:0 0 12px;">Item Pesanan</p>
        @foreach($order->orderItems->take(4) as $item)
        <div style="display:flex;align-items:center;padding:10px 0;border-bottom:1px solid #f1f5f9;">
          <div style="flex:1;color:#1e293b;font-size:.9rem;font-weight:600;">{{ optional($item->product)->name ?? 'Produk' }}</div>
          <div style="color:#64748b;font-size:.85rem;">{{ $item->quantity }}x &nbsp; Rp {{ number_format($item->price, 0, ',', '.') }}</div>
        </div>
        @endforeach
        @if($order->orderItems->count() > 4)
        <div style="color:#94a3b8;font-size:.82rem;padding-top:8px;">+{{ $order->orderItems->count() - 4 }} item lainnya</div>
        @endif
      </td></tr>

      {{-- CTA button --}}
      <tr><td style="background:#fff;padding:8px 40px 32px;text-align:center;">
        <a href="{{ route('customer.orders.show', $order->id) }}"
           style="display:inline-block;background:#0a4db8;color:#fff;text-decoration:none;padding:14px 36px;border-radius:999px;font-weight:700;font-size:.95rem;box-shadow:0 4px 16px rgba(10,77,184,.35);">
          Lihat Detail Pesanan &rarr;
        </a>
        @if($order->status && (($order->status instanceof \BackedEnum ? $order->status->value : $order->status) === 'delivered'))
        <div style="margin-top:16px;">
          <p style="color:#64748b;font-size:.85rem;margin:0 0 10px;">Produk sudah sampai? Yuk beri ulasan!</p>
          <a href="{{ route('customer.orders.show', $order->id) }}"
             style="display:inline-block;border:2px solid #0a4db8;color:#0a4db8;text-decoration:none;padding:10px 28px;border-radius:999px;font-weight:600;font-size:.85rem;">
            ⭐ Tulis Ulasan
          </a>
        </div>
        @endif
      </td></tr>

      {{-- Footer --}}
      <tr><td style="background:#f8fafc;border-top:1px solid #e2e8f0;border-radius:0 0 16px 16px;padding:20px 40px;text-align:center;">
        <p style="color:#94a3b8;font-size:.8rem;margin:0;">
          Ada pertanyaan? Hubungi kami via
          <a href="https://wa.me/6281234567890" style="color:#0a4db8;text-decoration:none;">WhatsApp</a>
          atau balas email ini.<br>
          &copy; {{ date('Y') }} Irvana Buah — Toko Buah Segar Online
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
