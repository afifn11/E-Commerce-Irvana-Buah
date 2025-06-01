<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('orders.index') }}" 
                   class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
                <div class="w-px h-6 bg-gray-300"></div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Detail Order
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false, orderToDelete: null, orderNumber: '' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Order Header Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $order->order_number }}</h1>
                            <p class="text-white/80 text-sm">Order ID: #{{ $order->id }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <!-- Order Status -->
                            @switch($order->status)
                                @case('pending')
                                    <span class="bg-yellow-500/20 backdrop-blur-sm text-yellow-100 px-4 py-2 rounded-full text-sm font-medium border border-yellow-500/30">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                                            <span>Pending</span>
                                        </div>
                                    </span>
                                    @break
                                @case('processing')
                                    <span class="bg-blue-500/20 backdrop-blur-sm text-blue-100 px-4 py-2 rounded-full text-sm font-medium border border-blue-500/30">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                                            <span>Diproses</span>
                                        </div>
                                    </span>
                                    @break
                                @case('shipped')
                                    <span class="bg-purple-500/20 backdrop-blur-sm text-purple-100 px-4 py-2 rounded-full text-sm font-medium border border-purple-500/30">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                                            <span>Dikirim</span>
                                        </div>
                                    </span>
                                    @break
                                @case('delivered')
                                    <span class="bg-green-500/20 backdrop-blur-sm text-green-100 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            <span>Selesai</span>
                                        </div>
                                    </span>
                                    @break
                                @case('cancelled')
                                    <span class="bg-red-500/20 backdrop-blur-sm text-red-100 px-4 py-2 rounded-full text-sm font-medium border border-red-500/30">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                            <span>Dibatalkan</span>
                                        </div>
                                    </span>
                                    @break
                            @endswitch

                            <!-- Payment Status -->
                            @switch($order->payment_status)
                                @case('pending')
                                    <span class="bg-orange-500/20 backdrop-blur-sm text-orange-100 px-4 py-2 rounded-full text-sm font-medium border border-orange-500/30">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Menunggu Bayar</span>
                                        </div>
                                    </span>
                                    @break
                                @case('paid')
                                    <span class="bg-green-500/20 backdrop-blur-sm text-green-100 px-4 py-2 rounded-full text-sm font-medium border border-green-500/30">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Lunas</span>
                                        </div>
                                    </span>
                                    @break
                                @case('failed')
                                    <span class="bg-red-500/20 backdrop-blur-sm text-red-100 px-4 py-2 rounded-full text-sm font-medium border border-red-500/30">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Gagal</span>
                                        </div>
                                    </span>
                                    @break
                                @case('refunded')
                                    <span class="bg-gray-500/20 backdrop-blur-sm text-gray-100 px-4 py-2 rounded-full text-sm font-medium border border-gray-500/30">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>
                                            <span>Refund</span>
                                        </div>
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Customer Information -->
                        <div class="space-y-6">
                            <!-- Customer Details -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Informasi Pelanggan</label>
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Informasi Pembayaran</label>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Metode Pembayaran:</span>
                                        <span class="font-medium text-gray-900 capitalize">
                                            @switch($order->payment_method)
                                                @case('cash')
                                                    Tunai
                                                    @break
                                                @case('credit_card')
                                                    Kartu Kredit
                                                    @break
                                                @case('bank_transfer')
                                                    Transfer Bank
                                                    @break
                                                @case('e_wallet')
                                                    E-Wallet
                                                    @break
                                                @default
                                                    {{ $order->payment_method }}
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="border-t pt-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-semibold text-gray-700">Total:</span>
                                            <span class="text-2xl font-bold text-green-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timestamps -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Dibuat</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $order->created_at->format('H:i') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Diupdate</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->updated_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-600">{{ $order->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="space-y-6">
                            <!-- Shipping Address -->
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Alamat Pengiriman</label>
                                <div class="space-y-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mt-1">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-gray-900 font-medium leading-relaxed">{{ $order->shipping_address }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $order->shipping_phone }}</p>
                                            <p class="text-sm text-gray-600">Nomor telepon</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Item Pesanan</label>
                                <div class="space-y-3">
                                    @if($order->orderItems && $order->orderItems->count() > 0)
                                        @foreach($order->orderItems as $item)
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</p>
                                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <p class="font-semibold text-purple-600">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-gray-500 font-medium">Tidak ada item</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            @if($order->notes)
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-4 border-b">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Catatan Order</span>
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $order->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white shadow-xl rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('orders.index') }}"
                       class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Kembali ke Daftar Order</span>
                    </a>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('orders.edit', $order->id) }}"
                           class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 text-sm rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="font-medium">Edit Order</span>
                        </a>
                        
                        <!-- Form Delete dengan hidden untuk modal -->
                        <form id="delete-order-form" action="{{ route('orders.destroy', $order->id) }}"
                              method="POST" class="inline" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        
                        <!-- Delete Button yang memicu modal -->
                        <button @click="showDeleteModal = true; orderToDelete = document.getElementById('delete-order-form'); orderNumber = '{{ $order->order_number }}'" 
                                class="group flex items-center space-x-2 bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="font-medium">Hapus Order</span>
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
                        Apakah Anda yakin ingin menghapus order <strong x-text="orderNumber"></strong>?
                        <br><span class="text-sm text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex space-x-3 justify-center">
                        <button @click="showDeleteModal = false" 
                                class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                            Batal
                        </button>
                        <button @click="if(orderToDelete) orderToDelete.submit()" 
                                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Ya, Hapus Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>