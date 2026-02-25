<x-app-layout>
    <x-slot name="header">
        <div class="dashboard-header">
            <div class="flex items-center justify-between">
                <div>
                    <p class="header-label">Overview</p>
                    <h2 class="header-title">Dashboard</h2>
                    <p class="header-sub">Selamat datang kembali, <span style="color:#fff;font-weight:600;">{{ Auth::user()->name }}</span></p>
                </div>
                <div class="flex items-center gap-3">
                    <button id="refreshStats" class="glass-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="glass-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        <div x-show="open" @click.away="open = false" class="filter-dropdown">
                            <h4 class="filter-title">Filter Tanggal</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="filter-label">Dari Tanggal</label>
                                    <input type="date" id="startDate" class="filter-input">
                                </div>
                                <div>
                                    <label class="filter-label">Sampai Tanggal</label>
                                    <input type="date" id="endDate" class="filter-input">
                                </div>
                                <button id="applyDateFilter" class="filter-apply-btn">Terapkan Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="dashboard-body">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <svg class="w-5 h-5" style="color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Produk</div>
                    <div class="stat-value" data-stat="totalProduk">{{ $totalProduk }}</div>
                    <div class="stat-footer">
                        <span class="stat-badge-green">{{ $produkAktif }} Aktif</span>
                        <span class="stat-badge-gray">{{ $produkFeatured }} Featured</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <svg class="w-5 h-5" style="color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Kategori</div>
                    <div class="stat-value" data-stat="totalKategori">{{ $totalKategori }}</div>
                    <div class="stat-footer">
                        <span class="stat-badge-gray">{{ $topCategories->sum('total_sold') }} Terjual</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <svg class="w-5 h-5" style="color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Pesanan</div>
                    <div class="stat-value" data-stat="totalPesanan">{{ $totalPesanan }}</div>
                    <div class="stat-footer">
                        <span class="stat-badge-green">{{ $pesananSelesai }} Selesai</span>
                        <span class="stat-badge-warn">{{ $pesananPending }} Pending</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-wrap">
                        <svg class="w-5 h-5" style="color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div class="stat-meta">Pengguna</div>
                    <div class="stat-value" data-stat="totalPengguna">{{ $totalPengguna }}</div>
                    <div class="stat-footer">
                        <span class="stat-badge-green">{{ $penggunaBaru }} Baru</span>
                        <span class="stat-badge-gray">{{ $adminCount }} Admin</span>
                    </div>
                </div>
            </div>

            <!-- Revenue + Stock Alert -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
                <div class="glass-card lg:col-span-2">
                    <div class="glass-card-header">
                        <div>
                            <p class="glass-card-label">Pendapatan Total</p>
                            <p class="glass-card-value">@money($totalRevenue)</p>
                        </div>
                        <div style="text-align:right">
                            @if($growthMetrics['revenue']['growth'] > 0)
                                <span class="growth-up">↑ {{ number_format($growthMetrics['revenue']['growth'], 1) }}%</span>
                            @else
                                <span class="growth-down">↓ {{ number_format(abs($growthMetrics['revenue']['growth']), 1) }}%</span>
                            @endif
                            <p style="font-size:0.72rem;color:rgba(255,255,255,0.35);margin-top:2px;">dari bulan lalu</p>
                        </div>
                    </div>
                    <div class="glass-card-divider"></div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6">
                        <div class="revenue-item">
                            <p class="revenue-label">Hari Ini</p>
                            <p class="revenue-val">@money($revenueHariIni)</p>
                        </div>
                        <div class="revenue-item">
                            <p class="revenue-label">Minggu Ini</p>
                            <p class="revenue-val">@money($revenueBulanIni)</p>
                        </div>
                        <div class="revenue-item">
                            <p class="revenue-label">Bulan Ini</p>
                            <p class="revenue-val">@money($revenueBulanIni)</p>
                        </div>
                        <div class="revenue-item">
                            <p class="revenue-label">Pending</p>
                            <p class="revenue-val">@money($pembayaranPending)</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div style="padding:1.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                            <div class="icon-box-red">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h4 class="section-title">Peringatan Stok</h4>
                        </div>
                        <div class="space-y-3">
                            @if($produkStokRendah > 0)
                            <div class="stock-row">
                                <div style="display:flex;align-items:center;gap:0.5rem">
                                    <span class="dot-warn"></span>
                                    <span class="stock-label">Stok Rendah (≤10)</span>
                                </div>
                                <span class="stock-count">{{ $produkStokRendah }} Produk</span>
                            </div>
                            @endif
                            @if($produkHabis > 0)
                            <div class="stock-row">
                                <div style="display:flex;align-items:center;gap:0.5rem">
                                    <span class="dot-red"></span>
                                    <span class="stock-label">Stok Habis</span>
                                </div>
                                <span class="stock-count">{{ $produkHabis }} Produk</span>
                            </div>
                            @endif
                            @if($lowStockProducts->count() > 0)
                            <div style="margin-top:1rem">
                                <p class="stock-section-label">Produk Kritis</p>
                                <div class="space-y-2">
                                    @foreach($lowStockProducts as $product)
                                    <div class="stock-item-row">
                                        <span style="font-size:0.8rem;color:rgba(255,255,255,0.6)">{{ $product['name'] }}</span>
                                        <span style="font-size:0.8rem;font-weight:700;color:{{ $product['status'] == 'critical' ? '#f87171' : '#fbbf24' }}">{{ $product['stock'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if($produkStokRendah == 0 && $produkHabis == 0)
                            <div style="text-align:center;padding:1.5rem 0">
                                <svg style="width:40px;height:40px;color:#4ade80;margin:0 auto 0.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p style="font-size:0.8rem;color:rgba(255,255,255,0.4)">Semua stok aman</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions + Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
                <div class="glass-card lg:col-span-2">
                    <div style="padding:1.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                            <div class="icon-box-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="section-title">Aksi Cepat</h4>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <a href="{{ route('products.create') }}" class="quick-action-card">
                                <svg style="width:1.5rem;height:1.5rem;margin-bottom:0.5rem;color:rgba(255,255,255,0.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>Tambah Produk</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="quick-action-card">
                                <svg style="width:1.5rem;height:1.5rem;margin-bottom:0.5rem;color:rgba(255,255,255,0.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span>Kelola Kategori</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="quick-action-card">
                                <svg style="width:1.5rem;height:1.5rem;margin-bottom:0.5rem;color:rgba(255,255,255,0.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>Lihat Pesanan</span>
                            </a>
                            <a href="{{ route('users.index') }}" class="quick-action-card">
                                <svg style="width:1.5rem;height:1.5rem;margin-bottom:0.5rem;color:rgba(255,255,255,0.5)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Kelola User</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="glass-card">
                    <div style="padding:1.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                            <div class="icon-box-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="section-title">Aktivitas Terbaru</h4>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentActivities as $activity)
                            <div class="activity-row">
                                <div class="activity-dot"></div>
                                <div style="flex:1;min-width:0">
                                    <p class="activity-title">{{ $activity['title'] }}</p>
                                    <p class="activity-desc">{{ $activity['description'] }}</p>
                                </div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products + Recent Orders -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 pb-8">
                <div class="glass-card">
                    <div style="padding:1.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                            <div class="icon-box-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h4 class="section-title">Produk Terlaris</h4>
                        </div>
                        <div class="space-y-3">
                            @foreach($topProducts as $product)
                            <div class="product-row">
                                <div class="product-rank">{{ $loop->iteration }}</div>
                                <div style="flex:1;min-width:0">
                                    <p class="product-name">{{ $product->name }}</p>
                                    <p class="product-price">@money($product->price)</p>
                                </div>
                                <div style="text-align:right">
                                    <p class="product-sold">{{ $product->total_sold }} terjual</p>
                                    <p class="product-revenue">@money($product->price * $product->total_sold)</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('products.index') }}" class="view-all-link">Lihat Semua Produk →</a>
                    </div>
                </div>

                <div class="glass-card">
                    <div style="padding:1.5rem">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                            <div class="icon-box-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h4 class="section-title">Pesanan Terbaru</h4>
                        </div>
                        <div class="space-y-2">
                            @foreach($recentOrders as $order)
                            <div class="order-row">
                                <div>
                                    <p class="order-num">#{{ $order['order_number'] }}</p>
                                    <p class="order-customer">{{ $order['customer'] }}</p>
                                </div>
                                <div style="text-align:right">
                                    <p class="order-total">@money($order['total'])</p>
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:4px;margin-top:4px">
                                        <span class="status-badge @if($order['status'] == 'delivered') status-green @elseif($order['status'] == 'processing') status-blue @elseif($order['status'] == 'pending') status-yellow @elseif($order['status'] == 'cancelled') status-red @endif">{{ ucfirst($order['status']) }}</span>
                                        <span class="status-badge {{ $order['payment_status'] == 'paid' ? 'status-green' : 'status-yellow' }}">{{ ucfirst($order['payment_status']) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('orders.index') }}" class="view-all-link">Lihat Semua Pesanan →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
    .dashboard-body { background:#0a0a0a; min-height:100vh; padding:2rem 0 4rem; }
    .dashboard-header { background:rgba(255,255,255,0.04); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px); border:1px solid rgba(255,255,255,0.08); border-radius:16px; padding:1.5rem 2rem; }
    .header-label { font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.35); margin-bottom:0.25rem; }
    .header-title { font-size:2rem; font-weight:700; color:#fff; line-height:1; letter-spacing:-0.03em; }
    .header-sub { font-size:0.875rem; color:rgba(255,255,255,0.4); margin-top:0.375rem; }
    .glass-btn { display:flex; align-items:center; gap:0.5rem; padding:0.5rem 1rem; background:rgba(255,255,255,0.07); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:rgba(255,255,255,0.65); font-size:0.8rem; font-weight:500; cursor:pointer; transition:all 0.2s; }
    .glass-btn:hover { background:rgba(255,255,255,0.12); color:#fff; border-color:rgba(255,255,255,0.2); }
    .filter-dropdown { position:absolute; right:0; top:calc(100% + 8px); width:240px; background:#181818; border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:1.25rem; z-index:50; box-shadow:0 20px 60px rgba(0,0,0,0.6); }
    .filter-title { font-size:0.8rem; font-weight:600; color:#fff; margin-bottom:0.75rem; }
    .filter-label { display:block; font-size:0.7rem; color:rgba(255,255,255,0.4); margin-bottom:0.35rem; }
    .filter-input { width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; font-size:0.8rem; padding:0.5rem 0.75rem; outline:none; box-sizing:border-box; }
    .filter-input:focus { border-color:rgba(255,255,255,0.3); }
    .filter-apply-btn { width:100%; background:#fff; color:#000; font-weight:600; font-size:0.8rem; padding:0.5rem; border-radius:8px; border:none; cursor:pointer; margin-top:0.5rem; transition:opacity 0.2s; }
    .filter-apply-btn:hover { opacity:0.88; }
    .stat-card { background:rgba(255,255,255,0.04); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,0.08); border-radius:16px; padding:1.5rem; transition:all 0.3s ease; }
    .stat-card:hover { background:rgba(255,255,255,0.07); border-color:rgba(255,255,255,0.15); transform:translateY(-2px); }
    .stat-icon-wrap { width:40px; height:40px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:1rem; }
    .stat-meta { font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.35); margin-bottom:0.25rem; }
    .stat-value { font-size:2.5rem; font-weight:700; color:#fff; line-height:1; letter-spacing:-0.04em; margin-bottom:0.875rem; }
    .stat-footer { display:flex; gap:0.5rem; flex-wrap:wrap; }
    .stat-badge-green { font-size:0.68rem; padding:0.2rem 0.6rem; background:rgba(74,222,128,0.1); border:1px solid rgba(74,222,128,0.2); color:#4ade80; border-radius:100px; }
    .stat-badge-gray { font-size:0.68rem; padding:0.2rem 0.6rem; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:rgba(255,255,255,0.4); border-radius:100px; }
    .stat-badge-warn { font-size:0.68rem; padding:0.2rem 0.6rem; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.2); color:#fbbf24; border-radius:100px; }
    .glass-card { background:rgba(255,255,255,0.04); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,0.08); border-radius:16px; overflow:hidden; }
    .glass-card-header { display:flex; justify-content:space-between; align-items:flex-start; padding:1.5rem 1.5rem 1.25rem; }
    .glass-card-label { font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.35); margin-bottom:0.25rem; }
    .glass-card-value { font-size:1.75rem; font-weight:700; color:#fff; letter-spacing:-0.03em; }
    .glass-card-divider { height:1px; background:rgba(255,255,255,0.06); }
    .growth-up { font-size:1rem; font-weight:700; color:#4ade80; }
    .growth-down { font-size:1rem; font-weight:700; color:#f87171; }
    .revenue-item { padding:0.875rem; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:10px; text-align:center; }
    .revenue-label { font-size:0.68rem; color:rgba(255,255,255,0.35); margin-bottom:0.35rem; letter-spacing:0.05em; }
    .revenue-val { font-size:0.9rem; font-weight:600; color:#fff; }
    .section-title { font-size:0.875rem; font-weight:600; color:#fff; }
    .icon-box-white { width:32px; height:32px; background:rgba(255,255,255,0.08); border-radius:8px; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.6); }
    .icon-box-red { width:32px; height:32px; background:rgba(248,113,113,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#f87171; }
    .stock-row { display:flex; align-items:center; justify-content:space-between; }
    .stock-label { font-size:0.8rem; color:rgba(255,255,255,0.6); }
    .stock-count { font-size:0.8rem; font-weight:700; color:#fff; }
    .dot-warn { width:8px; height:8px; border-radius:50%; background:#fbbf24; flex-shrink:0; }
    .dot-red { width:8px; height:8px; border-radius:50%; background:#f87171; flex-shrink:0; }
    .stock-section-label { font-size:0.65rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(255,255,255,0.25); margin-bottom:0.5rem; }
    .stock-item-row { display:flex; justify-content:space-between; align-items:center; padding:0.4rem 0.75rem; background:rgba(255,255,255,0.03); border-radius:6px; }
    .quick-action-card { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:1.25rem 0.75rem; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.07); border-radius:12px; color:rgba(255,255,255,0.5); font-size:0.75rem; font-weight:500; text-decoration:none; transition:all 0.2s ease; text-align:center; }
    .quick-action-card:hover { background:rgba(255,255,255,0.08); border-color:rgba(255,255,255,0.15); color:#fff; transform:translateY(-1px); }
    .activity-row { display:flex; align-items:flex-start; gap:0.75rem; }
    .activity-dot { width:6px; height:6px; border-radius:50%; background:rgba(255,255,255,0.25); flex-shrink:0; margin-top:5px; }
    .activity-title { font-size:0.8rem; color:rgba(255,255,255,0.8); font-weight:500; }
    .activity-desc { font-size:0.72rem; color:rgba(255,255,255,0.35); margin-top:1px; }
    .activity-time { font-size:0.7rem; color:rgba(255,255,255,0.25); white-space:nowrap; flex-shrink:0; }
    .product-row { display:flex; align-items:center; gap:0.75rem; }
    .product-rank { width:28px; height:28px; border-radius:7px; background:rgba(255,255,255,0.06); display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; color:rgba(255,255,255,0.45); flex-shrink:0; }
    .product-name { font-size:0.82rem; font-weight:500; color:rgba(255,255,255,0.85); }
    .product-price { font-size:0.72rem; color:rgba(255,255,255,0.35); }
    .product-sold { font-size:0.82rem; font-weight:600; color:#fff; }
    .product-revenue { font-size:0.72rem; color:rgba(255,255,255,0.35); }
    .order-row { display:flex; justify-content:space-between; align-items:center; padding:0.5rem 0; border-bottom:1px solid rgba(255,255,255,0.04); }
    .order-row:last-child { border-bottom:none; }
    .order-num { font-size:0.82rem; font-weight:600; color:#fff; }
    .order-customer { font-size:0.72rem; color:rgba(255,255,255,0.35); }
    .order-total { font-size:0.875rem; font-weight:700; color:#fff; }
    .status-badge { font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:100px; font-weight:500; }
    .status-green { background:rgba(74,222,128,0.1); color:#4ade80; border:1px solid rgba(74,222,128,0.2); }
    .status-blue { background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.2); }
    .status-yellow { background:rgba(251,191,36,0.1); color:#fbbf24; border:1px solid rgba(251,191,36,0.2); }
    .status-red { background:rgba(248,113,113,0.1); color:#f87171; border:1px solid rgba(248,113,113,0.2); }
    .view-all-link { display:block; text-align:center; margin-top:1.25rem; font-size:0.78rem; color:rgba(255,255,255,0.3); text-decoration:none; transition:color 0.2s; }
    .view-all-link:hover { color:#fff; }
    </style>

    @push('scripts')
    <script>
        document.getElementById('refreshStats').addEventListener('click', function() {
            fetch('{{ route("dashboard.refresh") }}')
                .then(r => r.json())
                .then(data => {
                    if(data.success) {
                        document.querySelector('[data-stat="totalProduk"]').textContent = data.data.totalProduk;
                        document.querySelector('[data-stat="totalKategori"]').textContent = data.data.totalKategori;
                        document.querySelector('[data-stat="totalPesanan"]').textContent = data.data.totalPesanan;
                        document.querySelector('[data-stat="totalPengguna"]').textContent = data.data.totalPengguna;
                    }
                });
        });
        document.getElementById('applyDateFilter').addEventListener('click', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            if(!startDate || !endDate) { alert('Silakan pilih tanggal awal dan akhir'); return; }
            fetch('{{ route("dashboard.filter") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ start_date: startDate, end_date: endDate })
            }).then(r => r.json()).then(data => {
                if(data.success) {
                    document.querySelector('[data-stat="pesananHariIni"]') && (document.querySelector('[data-stat="pesananHariIni"]').textContent = data.data.orders);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
