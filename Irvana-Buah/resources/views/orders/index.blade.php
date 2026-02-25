<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <p class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="breadcrumb-sep">/</span><span>Pesanan</span></p>
                <h2 class="page-title">Manajemen Pesanan</h2>
            </div>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Pesanan
            </a>
        </div>
    </x-slot>

    <div class="dashboard-body" x-data="{ '{' } showDeleteModal: false, itemToDelete: null, itemName: '' { '}' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <x-modal name="success-notification" :show="true" max-width="md">
                    <div style="padding:2rem;text-align:center;">
                        <div style="width:52px;height:52px;background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--success)">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Berhasil!</h3>
                        <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">{{ session('success') }}</p>
                        <button x-on:click="show = false" class="btn btn-success btn-sm">OK</button>
                    </div>
                </x-modal>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="stat-card">
                    <div class="stat-icon-wrap"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
                    <div class="stat-meta">Total</div>
                    <div class="stat-value">{{ $stats['total_orders'] ?? $orders->total() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(251,191,36,0.1);border-color:rgba(251,191,36,0.15);color:var(--warning)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div class="stat-meta">Menunggu</div>
                    <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(96,165,250,0.1);border-color:rgba(96,165,250,0.15);color:var(--info)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
                    <div class="stat-meta">Diproses</div>
                    <div class="stat-value">{{ $stats['processing_orders'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(52,211,153,0.1);border-color:rgba(52,211,153,0.15);color:var(--success)"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg></div>
                    <div class="stat-meta">Selesai</div>
                    <div class="stat-value">{{ $stats['delivered_orders'] ?? 0 }}</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-wrap">
                @if($orders->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></div>
                        <p class="empty-state-title">Belum ada pesanan</p>
                        <p class="empty-state-text">Pesanan akan muncul di sini</p>
                    </div>
                @else
                    <table class="table-glass">
                        <thead><tr>
                            <th>No. Pesanan</th><th>Pelanggan</th><th>Status</th><th>Pembayaran</th><th>Total</th><th>Tanggal</th><th style="text-align:center;">Aksi</th>
                        </tr></thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><span style="font-size:0.82rem;font-weight:600;color:var(--accent);font-family:var(--font-mono)">{{ $order->order_number }}</span></td>
                                <td>
                                    <p style="font-size:0.84rem;font-weight:600;color:var(--text-primary)">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p style="font-size:0.75rem;color:var(--text-muted)">{{ $order->user->email ?? '' }}</p>
                                </td>
                                <td>
                                    @switch($order->status)
                                        @case('pending') <span class="badge badge-yellow"><span class="badge-dot"></span>Pending</span> @break
                                        @case('processing') <span class="badge badge-blue"><span class="badge-dot"></span>Diproses</span> @break
                                        @case('shipped') <span class="badge badge-purple"><span class="badge-dot"></span>Dikirim</span> @break
                                        @case('delivered') <span class="badge badge-green"><span class="badge-dot"></span>Selesai</span> @break
                                        @case('cancelled') <span class="badge badge-red"><span class="badge-dot"></span>Batal</span> @break
                                        @default <span class="badge badge-gray">{{ $order->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($order->payment_status)
                                        @case('paid') <span class="badge badge-green">Lunas</span> @break
                                        @case('pending') <span class="badge badge-yellow">Menunggu</span> @break
                                        @case('failed') <span class="badge badge-red">Gagal</span> @break
                                        @default <span class="badge badge-gray">{{ $order->payment_status }}</span>
                                    @endswitch
                                </td>
                                <td style="font-size:0.84rem;font-weight:600;color:var(--text-primary)">Rp{{ number_format($order->total_amount) }}</td>
                                <td style="font-size:0.8rem;color:var(--text-muted)">{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="table-actions" style="justify-content:center;">
                                        <a href="{{ route('orders.show', $order) }}" class="table-action-btn view" title="Detail">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}" class="table-action-btn edit" title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="table-action-btn delete" title="Hapus"
                                                x-on:click="showDeleteModal = true; itemToDelete = $event.target.closest('form'); itemName = '{{ $order->order_number }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(method_exists($orders, 'links'))
                    <div style="padding:1rem 1.25rem;"><div class="pagination-wrap">
                        <p class="pagination-info">Total {{ $orders->total() }} pesanan</p>
                        <div class="pagination-nav">{{ $orders->links() }}</div>
                    </div></div>
                    @endif
                @endif
            </div>

            {{-- Delete Modal --}}
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);">
                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     style="background:rgba(12,17,24,0.97);border:1px solid var(--glass-border-strong);border-radius:var(--radius-2xl);padding:2rem;max-width:26rem;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
                    <div style="width:52px;height:52px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;color:var(--danger)">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Konfirmasi Hapus</h3>
                    <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        <strong style="color:var(--text-primary)" x-text="itemName"></strong> akan dihapus permanen.
                    </p>
                    <div style="display:flex;gap:0.75rem;justify-content:center;">
                        <button x-on:click="showDeleteModal = false" class="btn btn-ghost">Batal</button>
                        <button x-on:click="if(itemToDelete) itemToDelete.submit()" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
