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
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-10 h-10 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

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
                        <div class="text-emerald-100 text-sm flex items-center">
                            <span class="w-2 h-2 bg-emerald-300 rounded-full mr-2 animate-pulse"></span>
                            Produk Aktif
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
                            Kategori Tersedia
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
                        <div class="text-amber-100 text-sm flex items-center">
                            <span class="w-2 h-2 bg-amber-300 rounded-full mr-2 animate-pulse"></span>
                            Pesanan Masuk
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
                        <div class="text-pink-100 text-sm flex items-center">
                            <span class="w-2 h-2 bg-pink-300 rounded-full mr-2 animate-pulse"></span>
                            Pengguna Aktif
                        </div>
                    </div>
                </div>

            </div>

            <!-- Welcome Card dengan Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Welcome Message -->
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
                                <h3 class="text-2xl font-bold text-white">Selamat Datang!</h3>
                                <p class="text-indigo-100 mt-1">Kamu sudah berhasil login dan siap untuk mengelola bisnis</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Tambah Produk</span>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m2 0h10V7a2 2 0 00-2-2H9z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Kelola Kategori</span>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Lihat Pesanan</span>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Kelola User</span>
                            </div>
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
                            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 font-medium">Produk baru ditambahkan</p>
                                    <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 font-medium">Pesanan baru masuk</p>
                                    <p class="text-xs text-gray-500">5 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 font-medium">Kategori diperbarui</p>
                                    <p class="text-xs text-gray-500">1 hari yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>