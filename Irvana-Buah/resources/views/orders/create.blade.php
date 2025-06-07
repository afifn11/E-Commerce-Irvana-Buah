<x-app-layout>
    <x-slot name="header">
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
                Buat Order Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Buat Order Baru</h1>
                            <p class="text-white/80 text-sm">Isi form di bawah untuk membuat order baru</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Terjadi kesalahan:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Customer Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Pelanggan</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Customer Selection -->
                                <div class="space-y-2">
                                    <label for="user_id" class="block text-sm font-semibold text-gray-700">
                                        Pelanggan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <select name="user_id" id="user_id"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('user_id') border-red-500 ring-red-500 @enderror"
                                                required>
                                            <option value="">-- Pilih Pelanggan --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} - {{ $user->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('user_id')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Order</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Total Amount -->
                                <div class="space-y-2">
                                    <label for="total_amount" class="block text-sm font-semibold text-gray-700">
                                        Total Amount <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="number" name="total_amount" id="total_amount" step="0.01" value="{{ old('total_amount') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('total_amount') border-red-500 ring-red-500 @enderror"
                                               placeholder="0.00"
                                               required>
                                    </div>
                                    @error('total_amount')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <!-- Order Status -->
                                <div class="space-y-2">
                                    <label for="status" class="block text-sm font-semibold text-gray-700">
                                        Status Order <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <select name="status" id="status"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('status') border-red-500 ring-red-500 @enderror"
                                                required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Pembayaran</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Payment Method -->
                                <div class="space-y-2">
                                    <label for="payment_method" class="block text-sm font-semibold text-gray-700">
                                        Metode Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                        <select name="payment_method" id="payment_method"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('payment_method') border-red-500 ring-red-500 @enderror"
                                                required>
                                            <option value="">-- Pilih Metode Pembayaran --</option>
                                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                        </select>
                                    </div>
                                    @error('payment_method')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <!-- Payment Status -->
                                <div class="space-y-2">
                                    <label for="payment_status" class="block text-sm font-semibold text-gray-700">
                                        Status Pembayaran <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <select name="payment_status" id="payment_status"
                                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('payment_status') border-red-500 ring-red-500 @enderror"
                                                required>
                                            <option value="">-- Pilih Status Pembayaran --</option>
                                            <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </div>
                                    @error('payment_status')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Pengiriman</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Shipping Phone -->
                                <div class="space-y-2">
                                    <label for="shipping_phone" class="block text-sm font-semibold text-gray-700">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('shipping_phone') border-red-500 ring-red-500 @enderror"
                                               placeholder="Contoh: +62812345678"
                                               required>
                                    </div>
                                    @error('shipping_phone')
                                        <p class="text-sm text-red-600 flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="space-y-2">
                                <label for="shipping_address" class="block text-sm font-semibold text-gray-700">
                                    Alamat Pengiriman <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <textarea name="shipping_address" id="shipping_address" rows="4"
                                              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none @error('shipping_address') border-red-500 ring-red-500 @enderror"
                                              placeholder="Masukkan alamat pengiriman lengkap..."
                                              required>{{ old('shipping_address') }}</textarea>
                                </div>
                                @error('shipping_address')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Informasi Tambahan</h3>
                            
                            <!-- Notes -->
                            <div class="space-y-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700">
                                    Catatan <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <textarea name="notes" id="notes" rows="4"
                                              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none @error('notes') border-red-500 ring-red-500 @enderror"
                                              placeholder="Masukkan catatan tambahan...">{{ old('notes') }}</textarea>
                                </div>
                                @error('notes')
                                    <p class="text-sm text-red-600 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row justify-end items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('orders.index') }}"
                               class="w-full sm:w-auto group flex items-center justify-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50">
                                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="font-medium">Batal</span>
                            </a>
                            <button type="submit"
                                    class="w-full sm:w-auto group flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="font-medium">Simpan Order</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Script for dynamic functionality -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Auto-set default values for status and payment_status
                    if (!document.getElementById('status').value) {
                        document.getElementById('status').value = 'pending';
                    }
                    if (!document.getElementById('payment_status').value) {
                        document.getElementById('payment_status').value = 'pending';
                    }

                    // Prevent negative values in total_amount
                    document.getElementById('total_amount').addEventListener('input', function(e) {
                        if (this.value < 0) {
                            this.value = 0;
                        }
                    });

                    // Optional: Fetch user details when user is selected
                    document.getElementById('user_id').addEventListener('change', function() {
                        const userId = this.value;
                        if (userId) {
                            // You could add AJAX here to fetch user details and pre-fill shipping info
                            // This would require a corresponding API endpoint in your controller
                        }
                    });
                });
            </script>
        </div>
    </div>
</x-app-layout>