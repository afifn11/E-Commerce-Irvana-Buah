<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><span>Pesanan</span></p>
                <h2 class="page-title">Manajemen Pesanan</h2>
            </div>
        </div>
    </x-slot>

    <div class="dashboard-body" x-data="{ showDeleteModal: false, itemToDelete: null, itemName: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div id="flash-success" style="background:rgba(52,211,153,0.12);border:1px solid rgba(52,211,153,0.25);color:#4ade80;padding:12px 16px;border-radius:10px;display:flex;align-items:center;gap:10px;margin-bottom:20px;font-size:.85rem;font-weight:500;">
                <svg style="width:18px;height:18px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1.1rem;line-height:1;">×</button>
            </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="stat-meta">Total Pesanan</div>
                    <div class="stat-value">{{ $stats['total_orders'] ?? $orders->total() }}</div>
                    <div class="stat-footer">
                        <span class="stat-badge-green">{{ $stats['paid_orders'] ?? 0 }} Lunas</span>
                        <span class="stat-badge-warn">{{ $stats['unpaid_orders'] ?? 0 }} Pending</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(251,191,36,0.1);border-color:rgba(251,191,36,0.15);">
                        <svg class="w-4 h-4" style="color:#fbbf24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="stat-meta">Menunggu</div>
                    <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(96,165,250,0.1);border-color:rgba(96,165,250,0.15);">
                        <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div class="stat-meta">Diproses</div>
                    <div class="stat-value">{{ $stats['processing_orders'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(52,211,153,0.1);border-color:rgba(52,211,153,0.15);">
                        <svg class="w-4 h-4" style="color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="stat-meta">Selesai</div>
                    <div class="stat-value">{{ $stats['delivered_orders'] ?? 0 }}</div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="table-wrap mb-4" style="padding:16px 20px;">
                <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
                    <div>
                        <label style="font-size:.72rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.05em;">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="No. pesanan / nama / email..."
                               style="padding:8px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.84rem;background:var(--surface);color:var(--text-primary);min-width:220px;">
                    </div>
                    <div>
                        <label style="font-size:.72rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.05em;">Status Pesanan</label>
                        <select name="status" style="padding:8px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.84rem;background:var(--surface);color:var(--text-primary);">
                            <option value="">Semua Status</option>
                            @foreach(\App\Enums\OrderStatus::cases() as $s)
                                <option value="{{ $s->value }}" {{ request('status') === $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="font-size:.72rem;font-weight:600;color:var(--text-muted);display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.05em;">Status Bayar</label>
                        <select name="payment_status" style="padding:8px 12px;border:1px solid var(--glass-border);border-radius:8px;font-size:.84rem;background:var(--surface);color:var(--text-primary);">
                            <option value="">Semua</option>
                            @foreach(\App\Enums\PaymentStatus::cases() as $p)
                                <option value="{{ $p->value }}" {{ request('payment_status') === $p->value ? 'selected' : '' }}>{{ $p->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;gap:8px;align-items:flex-end;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search','status','payment_status','user_id']))
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-wrap">
                @if($orders->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="empty-state-title">Belum ada pesanan</p>
                        <p class="empty-state-text">Pesanan pelanggan akan muncul di sini</p>
                    </div>
                @else
                    <div style="overflow-x:auto;">
                        <table class="table-glass" style="min-width:900px;">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Status Pesanan</th>
                                    <th>Status Bayar</th>
                                    <th>Metode</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            @php
                                $statusVal = $order->status instanceof \BackedEnum ? $order->status->value : (string)$order->status;
                                $payVal    = $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string)$order->payment_status;
                                $methodVal = $order->payment_method instanceof \BackedEnum ? $order->payment_method->value : (string)$order->payment_method;
                            @endphp
                            <tr id="row-{{ $order->id }}">
                                {{-- No Pesanan --}}
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" style="font-size:.82rem;font-weight:700;color:var(--accent);font-family:var(--font-mono);text-decoration:none;" title="Lihat detail">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                {{-- Pelanggan --}}
                                <td>
                                    <p style="font-size:.84rem;font-weight:600;color:var(--text-primary);margin:0;">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p style="font-size:.74rem;color:var(--text-muted);margin:0;">{{ $order->user->email ?? '' }}</p>
                                </td>
                                {{-- Status Pesanan - inline editable dropdown --}}
                                <td>
                                    <select class="inline-status-select" data-order="{{ $order->id }}" data-type="status"
                                            onchange="updateStatus(this)"
                                            style="{{ [
                                                'pending'    => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#3d2e00;color:#fbbf24;border-color:#5a4400;',
                                                'processing' => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0c1e3d;color:#60a5fa;border-color:#1a3566;',
                                                'shipped'    => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e1a4d;color:#c084fc;border-color:#4a2980;',
                                                'delivered'  => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0a2e1a;color:#34d399;border-color:#145228;',
                                                'cancelled'  => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e0c0c;color:#f87171;border-color:#4d1515;',
                                            ][$statusVal] ?? 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:rgba(255,255,255,.05);color:var(--text-secondary);border-color:var(--glass-border);' }}">

                                        @foreach(\App\Enums\OrderStatus::cases() as $s)
                                            <option value="{{ $s->value }}" {{ $statusVal === $s->value ? 'selected' : '' }}>
                                                {{ $s->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                {{-- Status Bayar - inline editable dropdown --}}
                                <td>
                                    <select class="inline-status-select" data-order="{{ $order->id }}" data-type="payment"
                                            onchange="updateStatus(this)"
                                            style="{{ [
                                                'paid'     => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0a2e1a;color:#34d399;border-color:#145228;',
                                                'pending'  => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#3d2e00;color:#fbbf24;border-color:#5a4400;',
                                                'failed'   => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e0c0c;color:#f87171;border-color:#4d1515;',
                                                'refunded' => 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:rgba(255,255,255,.04);color:#9ca3af;border-color:#374151;',
                                            ][$payVal] ?? 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:rgba(255,255,255,.05);color:var(--text-secondary);border-color:var(--glass-border);' }}">

                                        @foreach(\App\Enums\PaymentStatus::cases() as $p)
                                            <option value="{{ $p->value }}" {{ $payVal === $p->value ? 'selected' : '' }}>
                                                {{ $p->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                {{-- Metode --}}
                                <td>
                                    <span style="font-size:.8rem;color:var(--text-secondary);">
                                        @switch($methodVal)
                                            @case('midtrans') <span title="Bayar Online via Midtrans">🏦 Midtrans</span> @break
                                            @case('cash')     <span title="COD / Bayar di Tempat">💵 COD</span> @break
                                            @default          {{ $methodVal }}
                                        @endswitch
                                    </span>
                                </td>
                                {{-- Total --}}
                                <td>
                                    <span style="font-size:.85rem;font-weight:700;color:var(--text-primary);">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                {{-- Tanggal --}}
                                <td>
                                    <span style="font-size:.8rem;color:var(--text-muted);">{{ $order->created_at->format('d M Y') }}</span><br>
                                    <span style="font-size:.74rem;color:var(--text-muted);">{{ $order->created_at->format('H:i') }} WIB</span>
                                </td>
                                {{-- Aksi --}}
                                <td>
                                    <div class="table-actions" style="justify-content:center;">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="table-action-btn view" title="Detail Pesanan">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="table-action-btn delete" title="Hapus Pesanan"
                                                    x-on:click="showDeleteModal = true; itemToDelete = $event.target.closest('form'); itemName = '{{ addslashes($order->order_number) }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($orders, 'links'))
                    <div style="padding:1rem 1.25rem;">
                        <div class="pagination-wrap">
                            <p class="pagination-info">Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan</p>
                            <div class="pagination-nav">{{ $orders->appends(request()->query())->links() }}</div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>

            {{-- Delete Modal --}}
            <div x-show="showDeleteModal"
                 x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="display:none;background:rgba(0,0,0,0.75);backdrop-filter:blur(4px);">
                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     style="background:rgba(12,17,24,0.97);border:1px solid var(--glass-border-strong);border-radius:var(--radius-2xl);padding:2rem;max-width:26rem;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
                    <div style="width:52px;height:52px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--danger)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.5rem;">Konfirmasi Hapus</h3>
                    <p style="font-size:.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        Pesanan <strong style="color:var(--text-primary)" x-text="itemName"></strong> akan dihapus permanen.
                    </p>
                    <div style="display:flex;gap:.75rem;justify-content:center;">
                        <button x-on:click="showDeleteModal = false" class="btn btn-ghost">Batal</button>
                        <button x-on:click="if(itemToDelete) itemToDelete.submit()" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast-msg" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:none;padding:12px 20px;border-radius:12px;font-size:.85rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.4);transition:all .3s;min-width:220px;"></div>

    @push('scripts')
    <script>

    const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

    const STATUS_STYLES = {
        pending:    'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#3d2e00;color:#fbbf24;border-color:#5a4400;',
        processing: 'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0c1e3d;color:#60a5fa;border-color:#1a3566;',
        shipped:    'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e1a4d;color:#c084fc;border-color:#4a2980;',
        delivered:  'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0a2e1a;color:#34d399;border-color:#145228;',
        cancelled:  'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e0c0c;color:#f87171;border-color:#4d1515;',
        paid:       'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#0a2e1a;color:#34d399;border-color:#145228;',
        failed:     'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:#2e0c0c;color:#f87171;border-color:#4d1515;',
        refunded:   'padding:5px 10px;border-radius:20px;font-size:.75rem;font-weight:700;border:1px solid;cursor:pointer;background:rgba(255,255,255,.04);color:#9ca3af;border-color:#374151;',
    };

    function showToast(msg, ok = true) {
        const t = document.getElementById('toast-msg');
        t.textContent = msg;
        t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:9999;padding:12px 20px;border-radius:12px;font-size:.85rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.4);min-width:220px;display:block;${
            ok ? 'background:#0a2e1a;color:#34d399;border:1px solid #145228;'
               : 'background:#2e0c0c;color:#f87171;border:1px solid #4d1515;'
        }`;
        clearTimeout(t._timeout);
        t._timeout = setTimeout(() => t.style.display = 'none', 3500);
    }

    async function updateStatus(select) {
        const orderId = select.dataset.order;
        const type    = select.dataset.type;
        const value   = select.value;
        const prev    = select.querySelector('[selected]')?.value ?? value;

        select.disabled = true;
        select.style.opacity = '.5';

        const url  = type === 'payment'
            ? `/admin/orders/${orderId}/payment-status`
            : `/admin/orders/${orderId}/status`;
        const body = type === 'payment'
            ? { payment_status: value }
            : { status: value };

        try {
            const r = await fetch(url, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify(body),
            });
            const data = await r.json();

            if (data.success) {
                // Update warna dropdown setelah berhasil
                select.style.cssText = STATUS_STYLES[value] ?? STATUS_STYLES.pending;
                // Tandai sebagai selected
                select.querySelectorAll('option').forEach(o => o.selected = o.value === value);
                showToast('✓ ' + (data.message ?? 'Status diperbarui'));
            } else {
                showToast('✗ ' + (data.message ?? 'Gagal memperbarui'), false);
                // Rollback ke nilai sebelumnya
                select.value = prev;
            }
        } catch (e) {
            showToast('✗ Koneksi gagal', false);
            select.value = prev;
        } finally {
            select.disabled = false;
            select.style.opacity = '1';
        }
    }
    </script>
    @endpush

</x-app-layout>