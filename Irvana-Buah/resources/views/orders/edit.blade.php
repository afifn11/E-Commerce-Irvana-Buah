<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('orders.index') }}"
               class="group flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Daftar Order</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Edit Order</h1>
                            <p class="text-white/80 text-sm">Perbarui detail untuk order #{{ $order->order_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
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

                    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-2">
                            <label for="order_number" class="block text-sm font-semibold text-gray-700">Nomor Order</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <input type="text" id="order_number" value="{{ $order->order_number }}"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-200 bg-gray-100 rounded-xl shadow-sm cursor-not-allowed"
                                       readonly>
                            </div>
                             <p class="mt-1 text-xs text-gray-500">Nomor order tidak dapat diubah.</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="user_id" class="block text-sm font-semibold text-gray-700">Customer <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <select name="user_id" id="user_id"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('user_id') border-red-500 ring-red-500 @enderror"
                                        required>
                                    <option value="">-- Pilih Customer --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')
                                <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-semibold text-gray-700">Status Order <span class="text-red-500">*</span></label>
                                 <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5c0 1.1.9 2 2 2h5M9 7h.01"></path></svg>
                                    </div>
                                    <select name="status" id="status" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('status') border-red-500 ring-red-500 @enderror" required>
                                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                @error('status')
                                    <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="payment_status" class="block text-sm font-semibold text-gray-700">Status Pembayaran <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <select name="payment_status" id="payment_status" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('payment_status') border-red-500 ring-red-500 @enderror" required>
                                        <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('payment_status', $order->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                                @error('payment_status')
                                    <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="total_amount" class="block text-sm font-semibold text-gray-700">Total Amount <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">Rp</div>
                                    <input type="number" name="total_amount" id="total_amount" step="0.01" value="{{ old('total_amount', $order->total_amount) }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('total_amount') border-red-500 ring-red-500 @enderror"
                                           required>
                                </div>
                                @error('total_amount')
                                    <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="payment_method" class="block text-sm font-semibold text-gray-700">Metode Pembayaran <span class="text-red-500">*</span></label>
                                <div class="relative">
                                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <select name="payment_method" id="payment_method" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('payment_method') border-red-500 ring-red-500 @enderror" required>
                                        <option value="cash" {{ old('payment_method', $order->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="credit_card" {{ old('payment_method', $order->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="bank_transfer" {{ old('payment_method', $order->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="e_wallet" {{ old('payment_method', $order->payment_method) == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    </select>
                                </div>
                                @error('payment_method')
                                    <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                             <label for="shipping_address" class="block text-sm font-semibold text-gray-700">Alamat Pengiriman <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <textarea name="shipping_address" id="shipping_address" rows="3" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('shipping_address') border-red-500 ring-red-500 @enderror" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                            </div>
                             @error('shipping_address')
                                <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                            @enderror
                        </div>

                         <div class="space-y-2">
                             <label for="shipping_phone" class="block text-sm font-semibold text-gray-700">Nomor Telepon Pengiriman <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', $order->shipping_phone) }}" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('shipping_phone') border-red-500 ring-red-500 @enderror" required>
                            </div>
                             @error('shipping_phone')
                                <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                             <label for="notes" class="block text-sm font-semibold text-gray-700">Catatan <span class="text-gray-400">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <textarea name="notes" id="notes" rows="3" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('notes') border-red-500 ring-red-500 @enderror">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                             @error('notes')
                                <p class="text-sm text-red-600 flex items-center space-x-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg><span>{{ $message }}</span></p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-200 pt-6"></div>

                        @if($order->orderItems && $order->orderItems->count() > 0)
                            <div class="space-y-4">
                                <h3 class="text-xl font-bold text-gray-900">Item Order</h3>
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($order->orderItems as $item)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->product ? $item->product->name : $item->product_name }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->quantity }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 text-right font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-gray-50">
                                                <tr>
                                                    <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase">Total</td>
                                                    <td class="px-6 py-4 text-right text-lg font-bold text-indigo-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-gray-100 border border-gray-200 rounded-xl p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Waktu</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Dibuat:</span>
                                    <span class="text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Terakhir Update:</span>
                                    <span class="text-gray-600">{{ $order->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                             <a href="{{ route('orders.show', $order->id) }}"
                               class="w-full sm:w-auto text-center font-medium text-indigo-600 hover:text-indigo-800 transition-colors px-6 py-3 rounded-xl">
                                Lihat Detail
                            </a>
                            <a href="{{ route('orders.index') }}"
                               class="w-full sm:w-auto group flex items-center justify-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-200 px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-50">
                               <span class="font-medium">Batal</span>
                            </a>
                            <button type="submit"
                                    class="w-full sm:w-auto group flex items-center justify-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                <span class="font-medium">Update Order</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Status change confirmation for sensitive operations
        document.getElementById('status').addEventListener('change', function() {
            const status = this.value;
            if (status === 'cancelled') {
                if (!confirm('Apakah Anda yakin ingin membatalkan order ini? Tindakan ini mungkin tidak dapat diurungkan.')) {
                    this.value = '{{ $order->status }}'; // Revert to original status
                }
            }
        });

        document.getElementById('payment_status').addEventListener('change', function() {
            const paymentStatus = this.value;
            if (paymentStatus === 'refunded') {
                if (!confirm('Apakah Anda yakin ingin mengubah status pembayaran menjadi "Refunded"? Pastikan proses refund telah selesai.')) {
                    this.value = '{{ $order->payment_status }}'; // Revert to original status
                }
            }
        });

        // Format phone number input to allow numbers and specific characters
        document.getElementById('shipping_phone').addEventListener('input', function() {
            let value = this.value.replace(/[^\d+\-\s()]/g, '');
            this.value = value;
        });
    </script>
</x-app-layout>