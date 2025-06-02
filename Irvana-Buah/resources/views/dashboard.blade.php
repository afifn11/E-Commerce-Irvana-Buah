<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-lg p-6 shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                        {{ __('Dashboard') }}
                    </h2>
                    <p class="text-blue-100 mt-2 text-lg">Selamat datang kembali! Mari lihat perkembangan bisnis Anda</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="refreshStats" class="flex items-center text-white hover:text-blue-200 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-white hover:text-blue-200 transition-colors">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                            Filter
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10">
                            <div class="p-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Filter Tanggal</h4>
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                                        <input type="date" id="startDate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                                        <input type="date" id="endDate" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                    </div>
                                    <button id="applyDateFilter" class="w-full bg-indigo-600 text-white py-1 px-3 rounded-md text-sm hover:bg-indigo-700 transition-colors">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="statsContainer">
                <!-- Total Produk -->
                <div class="group relative bg-gradient-to-br from-emerald-500 to-green-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-emerald-100 text-sm font-medium">Total</div>
                                <div class="text-white text-xs opacity-75">Produk</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">{{ $totalProduk }}</div>
                        <div class="flex justify-between items-center">
                            <div class="text-emerald-100 text-sm flex items-center">
                                <span class="w-2 h-2 bg-emerald-300 rounded-full mr-2 animate-pulse"></span>
                                {{ $produkAktif }} Aktif
                            </div>
                            <div class="text-xs bg-white/20 px-2 py-1 rounded-full">
                                {{ $produkFeatured }} Featured
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="group relative bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-blue-100 text-sm font-medium">Total</div>
                                <div class="text-white text-xs opacity-75">Kategori</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">{{ $totalKategori }}</div>
                        <div class="text-blue-100 text-sm flex items-center">
                            <span class="w-2 h-2 bg-blue-300 rounded-full mr-2 animate-pulse"></span>
                            {{ $topCategories->sum('total_sold') }} Produk Terjual
                        </div>
                    </div>
                </div>

                <!-- Total Pesanan -->
                <div class="group relative bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-amber-100 text-sm font-medium">Total</div>
                                <div class="text-white text-xs opacity-75">Pesanan</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">{{ $totalPesanan }}</div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $pesananHariIni }} Hari Ini</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $pesananMingguIni }} Minggu Ini</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $pesananSelesai }} Selesai</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $pesananPending }} Pending</div>
                        </div>
                    </div>
                </div>

                <!-- Total Pengguna -->
                <div class="group relative bg-gradient-to-br from-pink-500 to-rose-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-pink-100 text-sm font-medium">Total</div>
                                <div class="text-white text-xs opacity-75">Pengguna</div>
                            </div>
                        </div>
                        <div class="text-4xl font-bold mb-2 group-hover:scale-110 transition-transform duration-300">{{ $totalPengguna }}</div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $penggunaAktif }} Aktif</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $penggunaBaru }} Baru</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $adminCount }} Admin</div>
                            <div class="bg-white/10 rounded px-1 py-0.5">{{ $growthMetrics['users']['growth'] > 0 ? '+' : '' }}{{ number_format($growthMetrics['users']['growth'], 1) }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Revenue Card -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-2xl font-bold text-white">Pendapatan</h3>
                                    <p class="text-indigo-100 mt-1">Ringkasan pendapatan bisnis Anda</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-white">@money($totalRevenue)</div>
                                <div class="text-indigo-100 text-sm">
                                    @if($growthMetrics['revenue']['growth'] > 0)
                                        <span class="text-green-300">↑ {{ number_format($growthMetrics['revenue']['growth'], 1) }}%</span> dari bulan lalu
                                    @else
                                        <span class="text-red-300">↓ {{ number_format(abs($growthMetrics['revenue']['growth']), 1) }}%</span> dari bulan lalu
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-xs text-gray-500 mb-1">Hari Ini</div>
                                <div class="text-lg font-semibold text-gray-800">@money($revenueHariIni)</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-xs text-gray-500 mb-1">Minggu Ini</div>
                                <div class="text-lg font-semibold text-gray-800">@money($revenueBulanIni)</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-xs text-gray-500 mb-1">Bulan Ini</div>
                                <div class="text-lg font-semibold text-gray-800">@money($revenueBulanIni)</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-xs text-gray-500 mb-1">Pending</div>
                                <div class="text-lg font-semibold text-gray-800">@money($pembayaranPending)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Alert -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            Peringatan Stok
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @if($produkStokRendah > 0)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700">Stok Rendah (≤10)</span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $produkStokRendah }} Produk</span>
                                </div>
                            @endif
                            
                            @if($produkHabis > 0)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-red-400 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700">Stok Habis</span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ $produkHabis }} Produk</span>
                                </div>
                            @endif
                            
                            @if($lowStockProducts->count() > 0)
                                <div class="mt-4">
                                    <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Produk dengan Stok Rendah</h5>
                                    <div class="space-y-2">
                                        @foreach($lowStockProducts as $product)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                                <span class="text-sm">{{ $product['name'] }}</span>
                                                <span class="text-sm font-bold {{ $product['status'] == 'critical' ? 'text-red-600' : 'text-yellow-600' }}">{{ $product['stock'] }} left</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if($produkStokRendah == 0 && $produkHabis == 0)
                                <div class="text-center py-4">
                                    <svg class="w-12 h-12 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">Semua produk memiliki stok yang cukup</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-white">Aksi Cepat</h3>
                                <p class="text-indigo-100 mt-1">Kelola bisnis Anda dengan cepat</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('products.create') }}" class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Produk</span>
                            </a>
                            <a href="{{ route('categories.index') }}" class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m2 0h10V7a2 2 0 00-2-2H9z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Kelola Kategori</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Lihat Pesanan</span>
                            </a>
                            <a href="{{ route('users.index') }}" class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Kelola User</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Aktivitas Terbaru
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-center p-3 bg-{{ $activity['color'] }}-50 rounded-lg">
                                    <div class="w-2 h-2 bg-{{ $activity['color'] }}-400 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900 font-medium">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['description'] }}</p>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ $activity['time'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Aktivitas →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Top Products -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            Produk Terlaris
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($topProducts as $product)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-xs font-bold text-blue-600">{{ $loop->iteration }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">@money($product->price)</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">{{ $product->total_sold }} Terjual</p>
                                        <p class="text-xs text-gray-500">@money($product->price * $product->total_sold)</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Produk →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            Pesanan Terbaru
                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">#{{ $order['order_number'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $order['customer'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">@money($order['total'])</p>
                                        <div class="flex items-center justify-end space-x-1">
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($order['status'] == 'delivered') bg-green-100 text-green-800
                                                @elseif($order['status'] == 'processing') bg-blue-100 text-blue-800
                                                @elseif($order['status'] == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order['status'] == 'cancelled') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($order['status']) }}
                                            </span>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($order['payment_status'] == 'paid') bg-green-100 text-green-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($order['payment_status']) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Pesanan →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Refresh stats button
            document.getElementById('refreshStats').addEventListener('click', function() {
                fetch('{{ route("dashboard.refresh") }}')
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Update stats
                            document.querySelector('[data-stat="totalProduk"]').textContent = data.data.totalProduk;
                            document.querySelector('[data-stat="totalKategori"]').textContent = data.data.totalKategori;
                            document.querySelector('[data-stat="totalPesanan"]').textContent = data.data.totalPesanan;
                            document.querySelector('[data-stat="totalPengguna"]').textContent = data.data.totalPengguna;
                            
                            // Show notification
                            Toastify({
                                text: "Data dashboard berhasil diperbarui!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4f46e5",
                            }).showToast();
                        }
                    });
            });

            // Date filter
            document.getElementById('applyDateFilter').addEventListener('click', function() {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                
                if(!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan akhir');
                    return;
                }
                
                fetch('{{ route("dashboard.filter") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        start_date: startDate,
                        end_date: endDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Update relevant stats
                        document.querySelector('[data-stat="pesananHariIni"]').textContent = data.data.orders;
                        document.querySelector('[data-stat="revenueHariIni"]').textContent = formatCurrency(data.data.revenue);
                        
                        // Show notification
                        Toastify({
                            text: `Data dari ${startDate} hingga ${endDate} berhasil dimuat`,
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4f46e5",
                        }).showToast();
                    }
                });
            });

            // Helper function to format currency
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
            }
        </script>
    @endpush
</x-app-layout>