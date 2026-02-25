<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <p class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <span class="breadcrumb-sep">/</span>
                    <span>Produk</span>
                </p>
                <h2 class="page-title">Manajemen Produk</h2>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="dashboard-body" x-data="{ showDeleteModal: false, productToDelete: null, productName: '' }">
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
                    <div class="stat-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Total</div>
                    <div class="stat-value">{{ $products->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(52,211,153,0.1);border-color:rgba(52,211,153,0.15);color:var(--success)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Aktif</div>
                    <div class="stat-value">{{ $products->where('is_active', true)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(251,191,36,0.1);border-color:rgba(251,191,36,0.15);color:var(--warning)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Unggulan</div>
                    <div class="stat-value">{{ $products->where('is_featured', true)->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-wrap" style="background:rgba(248,113,113,0.1);border-color:rgba(248,113,113,0.15);color:var(--danger)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Diskon</div>
                    <div class="stat-value">{{ $products->where('discount_price', '>', 0)->count() }}</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-wrap">
                @if($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="empty-state-title">Belum ada produk</p>
                        <p class="empty-state-text">Mulai tambahkan produk pertama Anda</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm" style="margin-top:1rem;">Tambah Produk</a>
                    </div>
                @else
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.75rem;">
                                        @php
                                            $imageUrl = null;
                                            if ($product->image) {
                                                if (filter_var($product->image, FILTER_VALIDATE_URL)) {
                                                    $imageUrl = $product->image;
                                                } else {
                                                    $imageUrl = Storage::url($product->image);
                                                }
                                            }
                                        @endphp
                                        <div style="width:36px;height:36px;border-radius:var(--radius-sm);overflow:hidden;flex-shrink:0;border:1px solid var(--glass-border);">
                                            @if($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;"
                                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div style="display:none;width:100%;height:100%;background:var(--accent-dim);align-items:center;justify-content:center;">
                                                    <span style="font-size:0.75rem;font-weight:700;color:var(--accent)">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                                </div>
                                            @else
                                                <div style="width:100%;height:100%;background:var(--accent-dim);display:flex;align-items:center;justify-content:center;">
                                                    <span style="font-size:0.75rem;font-weight:700;color:var(--accent)">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p style="font-size:0.84rem;font-weight:600;color:var(--text-primary)">{{ $product->name }}</p>
                                            @if($product->is_featured)
                                                <span class="badge badge-yellow" style="font-size:0.68rem;padding:0.1rem 0.4rem;margin-top:0.1rem;">Unggulan</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:0.82rem;">{{ $product->category->name ?? '—' }}</td>
                                <td>
                                    @if($product->discount_price)
                                        <p style="font-size:0.72rem;text-decoration:line-through;color:var(--text-muted)">Rp{{ number_format($product->price) }}</p>
                                        <p style="font-size:0.84rem;font-weight:600;color:var(--danger)">Rp{{ number_format($product->discount_price) }}</p>
                                    @else
                                        <p style="font-size:0.84rem;font-weight:600;color:var(--text-primary)">Rp{{ number_format($product->price) }}</p>
                                    @endif
                                </td>
                                <td style="font-size:0.84rem;font-weight:500;">{{ $product->stock ?? 0 }}</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge badge-green"><span class="badge-dot"></span>Aktif</span>
                                    @else
                                        <span class="badge badge-red"><span class="badge-dot"></span>Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions" style="justify-content:center;">
                                        <a href="{{ route('products.show', $product) }}" class="table-action-btn view" title="Detail">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="table-action-btn edit" title="Edit">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="table-action-btn delete" title="Hapus"
                                                x-on:click="showDeleteModal = true; productToDelete = $event.target.closest('form'); productName = '{{ $product->name }}'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(method_exists($products, 'links'))
                        <div style="padding:1rem 1.25rem;">
                            <div class="pagination-wrap">
                                <p class="pagination-info">Menampilkan {{ $products->count() }} produk</p>
                                <div class="pagination-nav">{{ $products->links() }}</div>
                            </div>
                        </div>
                    @else
                        <div style="padding:0.75rem 1.25rem;border-top:1px solid var(--glass-border);">
                            <p class="pagination-info">Menampilkan {{ $products->count() }} produk</p>
                        </div>
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
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Hapus Produk?</h3>
                    <p style="font-size:0.84rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        Produk <strong style="color:var(--text-primary)" x-text="productName"></strong> akan dihapus permanen.
                    </p>
                    <div style="display:flex;gap:0.75rem;justify-content:center;">
                        <button x-on:click="showDeleteModal = false" class="btn btn-ghost">Batal</button>
                        <button x-on:click="if(productToDelete) productToDelete.submit()" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
