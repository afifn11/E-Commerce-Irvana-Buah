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
                    Edit Order - {{ $order->order_number }}
                </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="order_number" class="block text-sm font-medium text-gray-700">Nomor Order</label>
                        <input type="text" id="order_number" value="{{ $order->order_number }}"
                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm cursor-not-allowed"
                               readonly>
                        <p class="mt-1 text-sm text-gray-500">Nomor order tidak dapat diubah</p>
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Customer</label>
                        <select name="user_id" id="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('user_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Customer --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ (old('user_id', $order->user_id) == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Order</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('status') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ (old('status', $order->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ (old('status', $order->status) == 'processing') ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ (old('status', $order->status) == 'shipped') ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ (old('status', $order->status) == 'delivered') ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ (old('status', $order->status) == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                            <select name="payment_status" id="payment_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('payment_status') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Status Pembayaran --</option>
                                <option value="pending" {{ (old('payment_status', $order->payment_status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ (old('payment_status', $order->payment_status) == 'paid') ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ (old('payment_status', $order->payment_status) == 'failed') ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ (old('payment_status', $order->payment_status) == 'refunded') ? 'selected' : '' }}>Refunded</option>
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                            <input type="number" name="total_amount" id="total_amount" step="0.01" value="{{ old('total_amount', $order->total_amount) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('total_amount') border-red-500 @enderror"
                                   required>
                            @error('total_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('payment_method') border-red-500 @enderror"
                                    required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="cash" {{ (old('payment_method', $order->payment_method) == 'cash') ? 'selected' : '' }}>Cash</option>
                                <option value="credit_card" {{ (old('payment_method', $order->payment_method) == 'credit_card') ? 'selected' : '' }}>Credit Card</option>
                                <option value="bank_transfer" {{ (old('payment_method', $order->payment_method) == 'bank_transfer') ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="e_wallet" {{ (old('payment_method', $order->payment_method) == 'e_wallet') ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('shipping_address') border-red-500 @enderror"
                                  required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', $order->shipping_phone) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('shipping_phone') border-red-500 @enderror"
                               required>
                        @error('shipping_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 @error('notes') border-red-500 @enderror">{{ old('notes', $order->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Order Items Section --}}
                    @if($order->orderItems && $order->orderItems->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Item Order</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $item->product ? $item->product->name : $item->product_name }}
                                                    </td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <div class="text-lg font-semibold text-gray-900">
                                        Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Order Dates Info --}}
                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Waktu</h3>
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

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="text-gray-600 hover:underline mr-4">Lihat Detail</a>
                        <a href="{{ route('orders.index') }}"
                           class="text-gray-600 hover:underline mr-4">Batal</a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Status change confirmation for sensitive operations
        document.getElementById('status').addEventListener('change', function() {
            const status = this.value;
            if (status === 'cancelled') {
                if (!confirm('Apakah Anda yakin ingin membatalkan order ini?')) {
                    this.value = '{{ $order->status }}';
                }
            }
        });

        document.getElementById('payment_status').addEventListener('change', function() {
            const paymentStatus = this.value;
            if (paymentStatus === 'refunded') {
                if (!confirm('Apakah Anda yakin ingin mengubah status pembayaran menjadi refunded?')) {
                    this.value = '{{ $order->payment_status }}';
                }
            }
        });

        // Format currency input
        document.getElementById('total_amount').addEventListener('input', function() {
            let value = this.value.replace(/[^\d.]/g, '');
            if (value.split('.').length > 2) {
                value = value.substring(0, value.lastIndexOf('.'));
            }
            this.value = value;
        });

        // Format phone number input
        document.getElementById('shipping_phone').addEventListener('input', function() {
            let value = this.value.replace(/[^\d+\-\s()]/g, '');
            this.value = value;
        });
    </script>
</x-app-layout>