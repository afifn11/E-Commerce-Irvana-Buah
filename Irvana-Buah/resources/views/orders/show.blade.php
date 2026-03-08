<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span>
                    <a href="{{ route('admin.orders.index') }}">Pesanan</a><span class="breadcrumb-sep">/</span>
                    <span style="font-family:var(--font-mono)">{{ $order->order_number }}</span>
                </p>
                <h2 class="page-title">Detail Pesanan</h2>
            </div>
            <div style="display:flex;gap:8px;align-items:center;">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                      onsubmit="return confirm('Hapus pesanan {{ addslashes($order->order_number) }}? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $statusVal = $order->status instanceof \BackedEnum  ? $order->status->value  : (string)$order->status;
                $payVal    = $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string)$order->payment_status;
                $methodVal = $order->payment_method instanceof \BackedEnum ? $order->payment_method->value : (string)$order->payment_method;

                $statusColors = [
                    'pending'    => ['bg'=>'rgba(251,191,36,.15)',  'color'=>'#fbbf24', 'border'=>'rgba(251,191,36,.3)'],
                    'processing' => ['bg'=>'rgba(96,165,250,.15)',  'color'=>'#60a5fa', 'border'=>'rgba(96,165,250,.3)'],
                    'shipped'    => ['bg'=>'rgba(192,132,252,.15)', 'color'=>'#c084fc', 'border'=>'rgba(192,132,252,.3)'],
                    'delivered'  => ['bg'=>'rgba(52,211,153,.15)',  'color'=>'#34d399', 'border'=>'rgba(52,211,153,.3)'],
                    'cancelled'  => ['bg'=>'rgba(248,113,113,.15)', 'color'=>'#f87171', 'border'=>'rgba(248,113,113,.3)'],
                ];
                $payColors = [
                    'paid'     => ['bg'=>'rgba(52,211,153,.15)',  'color'=>'#34d399', 'border'=>'rgba(52,211,153,.3)'],
                    'pending'  => ['bg'=>'rgba(251,191,36,.15)',  'color'=>'#fbbf24', 'border'=>'rgba(251,191,36,.3)'],
                    'failed'   => ['bg'=>'rgba(248,113,113,.15)', 'color'=>'#f87171', 'border'=>'rgba(248,113,113,.3)'],
                    'refunded' => ['bg'=>'rgba(156,163,175,.15)', 'color'=>'#9ca3af', 'border'=>'rgba(156,163,175,.3)'],
                ];
                $sc = $statusColors[$statusVal] ?? $statusColors['pending'];
                $pc = $payColors[$payVal]       ?? $payColors['pending'];
            @endphp

            {{-- Header Banner --}}
            <div class="table-wrap mb-5" style="padding:28px 32px;background:linear-gradient(135deg,#0d1f4d 0%,#0a1530 100%);border-color:rgba(96,165,250,.2);">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;">
                    <div>
                        <div style="font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:8px;">Nomor Pesanan</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#fff;font-family:var(--font-mono);letter-spacing:1px;line-height:1;">
                            {{ $order->order_number }}
                        </div>
                        <div style="margin-top:8px;font-size:.8rem;color:rgba(255,255,255,.4);">
                            ID #{{ $order->id }} &bull; {{ $order->created_at->format('d M Y, H:i') }} WIB
                            &bull; {{ $order->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <span id="badge-status" style="padding:8px 18px;border-radius:24px;font-size:.82rem;font-weight:700;
                            background:{{ $sc['bg'] }};color:{{ $sc['color'] }};border:1px solid {{ $sc['border'] }};">
                            ● {{ \App\Enums\OrderStatus::from($statusVal)->label() }}
                        </span>
                        <span id="badge-pay" style="padding:8px 18px;border-radius:24px;font-size:.82rem;font-weight:700;
                            background:{{ $pc['bg'] }};color:{{ $pc['color'] }};border:1px solid {{ $pc['border'] }};">
                            @if($payVal === 'paid') ✓ @elseif($payVal === 'pending') ⏳ @elseif($payVal === 'failed') ✗ @endif
                            {{ \App\Enums\PaymentStatus::from($payVal)->label() }}
                        </span>
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

                {{-- UPDATE STATUS PANEL --}}
                <div class="table-wrap" style="padding:22px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
                        <div style="width:32px;height:32px;background:rgba(96,165,250,.1);border:1px solid rgba(96,165,250,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Update Status</h4>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:14px;">
                        <div>
                            <label style="font-size:.72rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em;">Status Pesanan</label>
                            <select id="sel-status" style="width:100%;padding:9px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.85rem;background:var(--surface);color:var(--text-primary);">
                                @foreach(\App\Enums\OrderStatus::cases() as $s)
                                    <option value="{{ $s->value }}" {{ $statusVal === $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size:.72rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em;">Status Pembayaran</label>
                            <select id="sel-pay" style="width:100%;padding:9px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.85rem;background:var(--surface);color:var(--text-primary);">
                                @foreach(\App\Enums\PaymentStatus::cases() as $p)
                                    <option value="{{ $p->value }}" {{ $payVal === $p->value ? 'selected' : '' }}>{{ $p->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="btn-save" onclick="saveStatus()" class="btn btn-primary" style="width:100%;justify-content:center;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan Status
                        </button>
                        <div id="status-msg" style="display:none;font-size:.82rem;padding:9px 13px;border-radius:8px;text-align:center;"></div>
                    </div>
                </div>

                {{-- INFO PELANGGAN --}}
                <div class="table-wrap" style="padding:22px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
                        <div style="width:32px;height:32px;background:rgba(52,211,153,.1);border:1px solid rgba(52,211,153,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Info Pelanggan</h4>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:0;">
                        @php $rows = [
                            ['Nama',  $order->user->name ?? 'N/A'],
                            ['Email', $order->user->email ?? '-'],
                            ['Telepon', $order->shipping_phone ?? '-'],
                        ] @endphp
                        @foreach($rows as [$label, $val])
                        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--glass-border);">
                            <span style="font-size:.8rem;color:var(--text-muted);">{{ $label }}</span>
                            <span style="font-size:.84rem;font-weight:600;color:var(--text-primary);text-align:right;max-width:60%;">{{ $val }}</span>
                        </div>
                        @endforeach
                        <div style="padding:10px 0;">
                            <span style="font-size:.8rem;color:var(--text-muted);display:block;margin-bottom:5px;">Alamat Pengiriman</span>
                            <span style="font-size:.84rem;color:var(--text-secondary);line-height:1.6;">{{ $order->shipping_address ?? '-' }}</span>
                        </div>
                        @if($order->notes)
                        <div style="margin-top:10px;padding:10px 14px;background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.15);border-radius:8px;">
                            <span style="font-size:.72rem;font-weight:700;color:#fbbf24;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:4px;">📝 Catatan</span>
                            <span style="font-size:.83rem;color:var(--text-secondary);">{{ $order->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- INFO PEMBAYARAN --}}
                <div class="table-wrap" style="padding:22px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
                        <div style="width:32px;height:32px;background:rgba(192,132,252,.1);border:1px solid rgba(192,132,252,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#c084fc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Info Pembayaran</h4>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:0;">
                        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--glass-border);">
                            <span style="font-size:.8rem;color:var(--text-muted);">Metode</span>
                            <span style="font-size:.84rem;font-weight:600;color:var(--text-primary);">
                                @switch($methodVal)
                                    @case('midtrans') 🏦 Online (Midtrans) @break
                                    @case('cash')     💵 COD / Tunai       @break
                                    @default          {{ $methodVal }}
                                @endswitch
                            </span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--glass-border);">
                            <span style="font-size:.8rem;color:var(--text-muted);">Status Bayar</span>
                            <span id="pay-badge-detail" style="font-size:.8rem;font-weight:700;padding:4px 12px;border-radius:20px;
                                background:{{ $pc['bg'] }};color:{{ $pc['color'] }};border:1px solid {{ $pc['border'] }};">
                                {{ \App\Enums\PaymentStatus::from($payVal)->label() }}
                            </span>
                        </div>
                        @if(($order->discount_amount ?? 0) > 0)
                        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--glass-border);">
                            <span style="font-size:.8rem;color:var(--text-muted);">Diskon Kupon</span>
                            <span style="font-size:.84rem;color:#34d399;font-weight:600;">− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if(($order->points_redeemed ?? 0) > 0)
                        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--glass-border);">
                            <span style="font-size:.8rem;color:var(--text-muted);">Poin Ditukar</span>
                            <span style="font-size:.84rem;color:#34d399;font-weight:600;">{{ $order->points_redeemed }} poin (− Rp{{ number_format($order->points_redeemed * 10, 0, ',', '.') }})</span>
                        </div>
                        @endif
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;">
                            <span style="font-size:.9rem;font-weight:700;color:var(--text-primary);">Total Bayar</span>
                            <span style="font-size:1.2rem;font-weight:800;color:var(--accent);">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($order->midtrans_transaction_id)
                        <div style="margin-top:6px;padding:10px 14px;background:rgba(96,165,250,.06);border:1px solid rgba(96,165,250,.15);border-radius:8px;">
                            <span style="font-size:.7rem;font-weight:700;color:#60a5fa;text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:3px;">Midtrans TID</span>
                            <span style="font-size:.78rem;color:var(--text-secondary);font-family:var(--font-mono);word-break:break-all;">{{ $order->midtrans_transaction_id }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- TIMELINE --}}
                <div class="table-wrap" style="padding:22px 24px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
                        <div style="width:32px;height:32px;background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg class="w-4 h-4" style="color:#fbbf24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">Alur Pesanan</h4>
                    </div>
                    @php
                        $steps = ['pending'=>'Menunggu', 'processing'=>'Diproses', 'shipped'=>'Dikirim', 'delivered'=>'Selesai'];
                        $stepKeys = array_keys($steps);
                        $currIdx  = array_search($statusVal, $stepKeys) ?? -1;
                    @endphp
                    <div style="display:flex;flex-direction:column;gap:2px;">
                    @foreach($steps as $key => $label)
                    @php $idx = array_search($key, $stepKeys); $done = $idx <= $currIdx; $active = $idx === $currIdx; @endphp
                    <div style="display:flex;align-items:center;gap:14px;padding:10px 0;{{ !$loop->last ? 'border-bottom:1px solid var(--glass-border);' : '' }}">
                        <div style="width:28px;height:28px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;
                            {{ $active ? 'background:#60a5fa;color:#fff;box-shadow:0 0 0 4px rgba(96,165,250,.2);' : ($done ? 'background:rgba(52,211,153,.2);color:#34d399;' : 'background:rgba(255,255,255,.05);color:var(--text-muted);') }}">
                            {{ $done ? ($active ? ($idx+1) : '✓') : ($idx+1) }}
                        </div>
                        <div>
                            <span style="font-size:.84rem;font-weight:{{ $active ? '700' : '500' }};color:{{ $done ? 'var(--text-primary)' : 'var(--text-muted)' }};">{{ $label }}</span>
                            @if($active) <span style="display:block;font-size:.72rem;color:#60a5fa;font-weight:600;margin-top:2px;">← Status saat ini</span> @endif
                        </div>
                    </div>
                    @endforeach
                    @if($statusVal === 'cancelled')
                    <div style="display:flex;align-items:center;gap:14px;padding:10px 0;margin-top:4px;border-top:1px solid var(--glass-border);">
                        <div style="width:28px;height:28px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;background:rgba(248,113,113,.2);color:#f87171;">✗</div>
                        <span style="font-size:.84rem;font-weight:700;color:#f87171;">Dibatalkan <span style="font-size:.72rem;font-weight:500;color:var(--text-muted);"> ← Status saat ini</span></span>
                    </div>
                    @endif
                    </div>
                </div>

            </div>{{-- end grid 2-col --}}

            {{-- ITEM PESANAN --}}
            <div class="table-wrap mb-6">
                <div style="padding:16px 20px;border-bottom:1px solid var(--glass-border);display:flex;align-items:center;justify-content:space-between;">
                    <h4 style="font-size:.9rem;font-weight:700;color:var(--text-primary);margin:0;">
                        Item Pesanan
                        <span style="font-size:.78rem;font-weight:400;color:var(--text-muted);margin-left:6px;">({{ $order->orderItems->count() }} produk)</span>
                    </h4>
                </div>
                @if($order->orderItems->isEmpty())
                    <div class="empty-state" style="padding:2rem;">
                        <p class="empty-state-title">Tidak ada item</p>
                    </div>
                @else
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:right;">Harga Satuan</th>
                                <th style="text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $item)
                        @php $product = $item->product; @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <img src="{{ $product?->image_url ?? '' }}" alt="{{ $product?->name }}"
                                         style="width:46px;height:46px;object-fit:cover;border-radius:8px;border:1px solid var(--glass-border);"
                                         onerror="this.style.display='none'">
                                    <div>
                                        <p style="font-size:.85rem;font-weight:600;color:var(--text-primary);margin:0;">{{ $product?->name ?? 'Produk dihapus' }}</p>
                                        <p style="font-size:.74rem;color:var(--text-muted);margin:0;">ID: {{ $item->product_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span style="font-size:.85rem;font-weight:700;color:var(--text-primary);">{{ $item->quantity }} kg</span>
                            </td>
                            <td style="text-align:right;">
                                <span style="font-size:.84rem;color:var(--text-secondary);">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                            </td>
                            <td style="text-align:right;">
                                <span style="font-size:.85rem;font-weight:700;color:var(--accent);">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            @if(($order->discount_amount ?? 0) > 0)
                            <tr>
                                <td colspan="3" style="text-align:right;font-size:.82rem;color:var(--text-muted);">Diskon Kupon</td>
                                <td style="text-align:right;font-size:.84rem;color:#34d399;font-weight:600;">− Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if(($order->points_redeemed ?? 0) > 0)
                            <tr>
                                <td colspan="3" style="text-align:right;font-size:.82rem;color:var(--text-muted);">Poin ({{ $order->points_redeemed }} pts)</td>
                                <td style="text-align:right;font-size:.84rem;color:#34d399;font-weight:600;">− Rp{{ number_format($order->points_redeemed * 10, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr style="border-top:2px solid var(--glass-border);">
                                <td colspan="3" style="text-align:right;font-size:.92rem;font-weight:700;color:var(--text-primary);padding-top:12px;">TOTAL</td>
                                <td style="text-align:right;font-size:1.05rem;font-weight:800;color:var(--accent);padding-top:12px;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>

        </div>
    </div>

    {{-- Toast --}}
    <div id="toast-show" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:none;padding:12px 20px;border-radius:12px;font-size:.85rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.4);min-width:220px;"></div>

    @push('scripts')
    <script>
    const CSRF    = document.querySelector('meta[name=csrf-token]')?.content ?? '';
    const orderId = {{ $order->id }};

    const PAY_COLORS = {
        paid:     { bg:'rgba(52,211,153,.15)',  color:'#34d399', border:'rgba(52,211,153,.3)',  label:'✓ Sudah Dibayar' },
        pending:  { bg:'rgba(251,191,36,.15)',  color:'#fbbf24', border:'rgba(251,191,36,.3)',  label:'⏳ Menunggu Pembayaran' },
        failed:   { bg:'rgba(248,113,113,.15)', color:'#f87171', border:'rgba(248,113,113,.3)', label:'✗ Gagal' },
        refunded: { bg:'rgba(156,163,175,.15)', color:'#9ca3af', border:'rgba(156,163,175,.3)', label:'↩ Dikembalikan' },
    };
    const STATUS_COLORS = {
        pending:    { bg:'rgba(251,191,36,.15)',  color:'#fbbf24', border:'rgba(251,191,36,.3)',  label:'● Menunggu' },
        processing: { bg:'rgba(96,165,250,.15)',  color:'#60a5fa', border:'rgba(96,165,250,.3)',  label:'● Diproses' },
        shipped:    { bg:'rgba(192,132,252,.15)', color:'#c084fc', border:'rgba(192,132,252,.3)', label:'● Dikirim' },
        delivered:  { bg:'rgba(52,211,153,.15)',  color:'#34d399', border:'rgba(52,211,153,.3)',  label:'● Selesai' },
        cancelled:  { bg:'rgba(248,113,113,.15)', color:'#f87171', border:'rgba(248,113,113,.3)', label:'● Dibatalkan' },
    };

    function showToast(msg, ok = true) {
        const t = document.getElementById('toast-show');
        t.textContent = msg;
        t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:9999;padding:12px 20px;border-radius:12px;font-size:.85rem;font-weight:600;min-width:220px;display:block;box-shadow:0 8px 32px rgba(0,0,0,.4);${
            ok ? 'background:#0a2e1a;color:#34d399;border:1px solid #145228;'
               : 'background:#2e0c0c;color:#f87171;border:1px solid #4d1515;'
        }`;
        clearTimeout(t._to);
        t._to = setTimeout(() => t.style.display = 'none', 3500);
    }

    function setBadge(id, color, label) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.background = color.bg;
        el.style.color      = color.color;
        el.style.borderColor = color.border;
        el.textContent      = label;
    }

    async function saveStatus() {
        const btn       = document.getElementById('btn-save');
        const statusVal = document.getElementById('sel-status').value;
        const payVal    = document.getElementById('sel-pay').value;
        const msg       = document.getElementById('status-msg');

        btn.disabled    = true;
        btn.innerHTML   = '<span style="opacity:.6">⏳ Menyimpan...</span>';
        msg.style.display = 'none';

        try {
            const [r1, r2] = await Promise.all([
                fetch(`/admin/orders/${orderId}/status`, {
                    method:'PATCH', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify({ status: statusVal }),
                }),
                fetch(`/admin/orders/${orderId}/payment-status`, {
                    method:'PATCH', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
                    body: JSON.stringify({ payment_status: payVal }),
                }),
            ]);

            const [d1, d2] = await Promise.all([r1.json(), r2.json()]);

            if (d1.success && d2.success) {
                setBadge('badge-status', STATUS_COLORS[statusVal], STATUS_COLORS[statusVal]?.label ?? statusVal);
                setBadge('badge-pay',    PAY_COLORS[payVal],       PAY_COLORS[payVal]?.label    ?? payVal);
                setBadge('pay-badge-detail', PAY_COLORS[payVal],   PAY_COLORS[payVal]?.label    ?? payVal);
                showToast('✓ Status berhasil diperbarui');
            } else {
                showToast('✗ ' + (d1.message || d2.message || 'Gagal menyimpan'), false);
            }
        } catch(e) {
            showToast('✗ Koneksi gagal', false);
        } finally {
            btn.disabled  = false;
            btn.innerHTML = '<svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg> Simpan Perubahan Status';
        }
    }
    </script>
    @endpush

</x-app-layout>
