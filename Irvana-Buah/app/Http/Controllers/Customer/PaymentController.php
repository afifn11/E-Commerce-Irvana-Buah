<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private function serverKey(): string { return config('midtrans.server_key'); }
    private function baseUrl(): string   { return config('midtrans.base_url'); }

    /** Create Midtrans Snap token for an order */
    public function createSnap(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        $user  = $order->user;
        $items = $order->orderItems->map(fn($item) => [
            'id'       => (string) $item->product_id,
            'price'    => (int) $item->price,
            'quantity' => $item->quantity,
            'name'     => substr($item->product->name ?? 'Produk', 0, 50),
        ])->toArray();

        if ($order->discount_amount > 0) {
            $items[] = [
                'id'       => 'DISCOUNT',
                'price'    => -(int) $order->discount_amount,
                'quantity' => 1,
                'name'     => 'Diskon',
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'item_details'    => $items,
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $order->shipping_phone,
            ],
            'callbacks' => [
                'finish'  => route('checkout.success', $order->id),
                'unfinish'=> route('customer.orders.show', $order->id),
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey(), '')
            ->post(str_replace('/v2', '', $this->baseUrl()) . '/snap/v1/transactions', $payload);

        if ($response->successful()) {
            $token = $response->json('token');
            $order->update(['midtrans_snap_token' => $token]);
            return response()->json(['token' => $token, 'client_key' => config('midtrans.client_key')]);
        }

        Log::error('Midtrans snap error', $response->json());
        return response()->json(['error' => 'Gagal membuat sesi pembayaran.'], 500);
    }

    /** Midtrans webhook notification */
    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;

        // Verify signature
        $signatureKey = hash('sha512',
            $orderId . $payload['status_code'] . $payload['gross_amount'] . $this->serverKey()
        );

        if ($signatureKey !== ($payload['signature_key'] ?? '')) {
            Log::warning('Midtrans invalid signature', $payload);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';

        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $order->update(['payment_status' => 'paid', 'midtrans_transaction_id' => $payload['transaction_id']]);
        } elseif ($transactionStatus === 'settlement') {
            $order->update(['payment_status' => 'paid', 'midtrans_transaction_id' => $payload['transaction_id']]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['payment_status' => 'failed']);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => 'pending']);
        }

        return response()->json(['message' => 'OK']);
    }
}
