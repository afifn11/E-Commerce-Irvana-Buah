<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('products.index') }}" 
                   class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
                <div class="w-px h-6 bg-gray-300"></div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Detail Produk
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, productToDelete: null, productName: '' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Header Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $product->name }}</h1>
                            <p class="text-white/80 text-sm">{{ $product->slug }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if ($product->is_active)
                                <span class="bg-green-500/20 backdrop-blur-sm text-green-100 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                        <span>Aktif</span>
                                    </div>
                                </span>
                            @else
                                <span class="bg-red-500/20 backdrop-blur-sm text-red-100 px-4 py-2 rounded-full text-sm font-medium border border-red-500/30">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                        <span>Nonaktif</span>
                                    </div>
                                </span>
                            @endif
                            
                            @if ($product->is_featured)
                                <span class="bg-yellow-500/20 backdrop-blur-sm text-yellow-100 px-4 py-2 rounded-full text-sm font-medium border border-yellow-500/30">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>Unggulan</span>
                                    </div>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Product Image Section - PERBAIKAN -->
                        <div class="space-y-4">
                            <div class="relative group">
                                @if($product->hasImage())
                                    <img src="{{ $product->image_url }}" 
                                        alt="{{ $product->name }}" 
                                        class="w-full h-80 object-cover rounded-2xl shadow-lg group-hover:shadow-2xl transition-all duration-300"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-product.png') }}'; this.parentElement.querySelector('.error-overlay').style.display='block';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Error overlay (hidden by default) -->
                                    <div class="error-overlay absolute inset-0 bg-red-50 rounded-2xl items-center justify-center border-2 border-dashed border-red-300" style="display: none;">
                                        <div class="text-center p-4">
                                            <svg class="w-12 h-12 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <p class="text-red-600 font-medium text-sm">Gambar tidak dapat dimuat</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center border-2 border-dashed border-gray-300">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">Tidak ada gambar</p>
                                            <p class="text-gray-400 text-sm mt-1">Upload gambar untuk produk ini</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Image info -->
                            @if($product->image)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Sumber gambar:</span> 
                                        @if(filter_var($product->image, FILTER_VALIDATE_URL))
                                            <span class="text-blue-600">URL Eksternal</span>
                                        @else
                                            <span class="text-green-600">File Lokal</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="space-y-6">
                            <!-- Category -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-900 font-medium">{{ $product->category->name ?? 'Tidak ada kategori' }}</span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Harga</label>
                                <div class="space-y-2">
                                    @if($product->discount_price)
                                        <div class="flex items-center space-x-3">
                                            <p class="text-lg line-through text-gray-500">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-lg text-xs font-medium">
                                                -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                            </span>
                                        </div>
                                        <p class="text-3xl font-bold text-green-600">Rp{{ number_format($product->discount_price, 0, ',', '.') }}</p>
                                        <p class="text-sm text-green-700 font-medium">
                                            Hemat Rp{{ number_format($product->price - $product->discount_price, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-3xl font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Stock -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Tersedia</label>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold text-gray-900">{{ $product->stock ?? 0 }}</p>
                                            <p class="text-sm text-gray-600">unit tersedia</p>
                                        </div>
                                    </div>
                                    @if(($product->stock ?? 0) < 10)
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                                            ⚠️ Stok Terbatas
                                        </span>
                                    @elseif(($product->stock ?? 0) > 50)
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            ✅ Stok Melimpah
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dibuat</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $product->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $product->created_at->format('H:i') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Diupdate</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $product->updated_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $product->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($product->description)
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Deskripsi Produk</span>
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('products.index') }}"
                       class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Kembali ke Daftar Produk</span>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="font-medium">Edit Produk</span>
                        </a>
                        
                        <!-- Form Delete dengan hidden untuk modal -->
                        <form id="delete-product-form" action="{{ route('products.destroy', $product->id) }}"
                              method="POST" class="inline" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        
                        <!-- Delete Button yang memicu modal -->
                        <button @click="showDeleteModal = true; productToDelete = document.getElementById('delete-product-form'); productName = '{{ $product->name }}'" 
                                class="group flex items-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="font-medium">Hapus Produk</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" 
             style="display: none;">
            <div x-show="showDeleteModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95" 
                 class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <div class="p-6 text-center">
                    {{-- Warning Icon --}}
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.667-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>

                    {{-- Warning Title --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Penghapusan</h3>

                    {{-- Warning Message --}}
                    <p class="text-gray-600 mb-6">
                        Apakah Anda yakin ingin menghapus produk <strong x-text="productName"></strong>?
                        <br><span class="text-sm text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex space-x-3 justify-center">
                        <button @click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                            Batal
                        </button>
                        <button @click="if(productToDelete) productToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Ya, Hapus Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>