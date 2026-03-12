<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    private function serverKey(): string { return config('midtrans.server_key', ''); }

    public function createSnap(Order $order)
    {
        Log::info("=== createSnap START for order #{$order->id} ({$order->order_number}) ===");

        // --- Auth check ---
        if ($order->user_id !== Auth::id()) {
            Log::warning("createSnap: unauthorized user " . Auth::id() . " for order {$order->user_id}");
            abort(403);
        }

        // --- Payment status check ---
        $payStatus = $order->payment_status instanceof \BackedEnum
            ? $order->payment_status->value
            : (string) $order->payment_status;
        Log::info("createSnap: payment_status = {$payStatus}");

        if ($payStatus === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        // --- Reuse existing token ---
        if (!empty($order->midtrans_snap_token)) {
            Log::info("createSnap: reusing existing token");
            return response()->json([
                'token'      => $order->midtrans_snap_token,
                'client_key' => config('midtrans.client_key'),
            ]);
        }

        // --- Check columns exist ---
        $hasSnapToken = Schema::hasColumn('orders', 'midtrans_snap_token');
        Log::info("createSnap: column midtrans_snap_token exists = " . ($hasSnapToken ? 'YES' : 'NO - MIGRATION BELUM DIJALANKAN!'));

        // --- Check server key ---
        $serverKey = $this->serverKey();
        if (empty($serverKey) || $serverKey === 'your-server-key-here') {
            Log::error("createSnap: MIDTRANS_SERVER_KEY belum diisi di .env!");
            return response()->json(['error' => 'Konfigurasi payment gateway belum lengkap. Hubungi admin.'], 500);
        }

        // --- Load relations ---
        $order->load(['orderItems.product', 'user']);
        $user = $order->user;
        Log::info("createSnap: user = {$user->email}, items = " . $order->orderItems->count());

        // --- Build item_details ---
        $items    = [];
        $itemsSum = 0;

        foreach ($order->orderItems as $item) {
            $price     = (int) $item->price;
            $qty       = (int) $item->quantity;
            $itemsSum += $price * $qty;
            $items[]   = [
                'id'       => (string) $item->product_id,
                'price'    => $price,
                'quantity' => $qty,
                'name'     => substr($item->product->name ?? 'Produk', 0, 50),
            ];
        }

        // Diskon kupon
        $discountAmount = (int) $order->discount_amount;
        if ($discountAmount > 0) {
            $items[]   = ['id' => 'COUPON', 'price' => -$discountAmount, 'quantity' => 1, 'name' => 'Diskon Kupon'];
            $itemsSum -= $discountAmount;
        }

        // Diskon poin
        $pointsRedeemed = (int) ($order->points_redeemed ?? 0);
        if ($pointsRedeemed > 0) {
            $pointsDiscount = $pointsRedeemed * 10;
            $items[]        = ['id' => 'POINTS', 'price' => -$pointsDiscount, 'quantity' => 1, 'name' => "Diskon Poin ({$pointsRedeemed} poin)"];
            $itemsSum      -= $pointsDiscount;
        }

        $grossAmount = (int) $order->total_amount;

        // Safety adjustment
        $diff = $grossAmount - $itemsSum;
        if ($diff !== 0) {
            Log::warning("createSnap: item sum mismatch! gross={$grossAmount} itemsSum={$itemsSum} diff={$diff}");
            $items[] = ['id' => 'ADJ', 'price' => $diff, 'quantity' => 1, 'name' => 'Penyesuaian'];
        }

        Log::info("createSnap: gross_amount={$grossAmount}, items=" . count($items));

        $payload = [
            'transaction_details' => [
                // Append timestamp agar unik jika order pernah dicoba sebelumnya
                'order_id'     => $order->order_number . '-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'item_details'     => $items,
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $order->shipping_phone ?? '',
            ],
            'callbacks' => [
                'finish'   => route('checkout.success', $order->id),
                'unfinish' => route('customer.orders.show', $order->id),
                'error'    => route('customer.orders.show', $order->id),
            ],
        ];

        // --- Call Midtrans API ---
        $isProduction = config('midtrans.is_production', false);
        $snapApiUrl   = $isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        Log::info("createSnap: calling {$snapApiUrl}");

        try {
            $response = Http::timeout(20)
                ->withoutVerifying()          // ← bypass SSL cert issue di localhost
                ->withBasicAuth($serverKey, '')
                ->acceptJson()
                ->post($snapApiUrl, $payload);

            $status   = $response->status();
            $respBody = $response->json();
            Log::info("createSnap: Midtrans response status={$status}", ['body' => $respBody]);

            if ($response->successful()) {
                $token = $respBody['token'] ?? null;
                if (!$token) {
                    Log::error("createSnap: response OK tapi token kosong", $respBody);
                    return response()->json(['error' => 'Token tidak diterima dari Midtrans.'], 500);
                }

                // Simpan token jika kolom ada
                if ($hasSnapToken) {
                    $order->update(['midtrans_snap_token' => $token]);
                }

                return response()->json([
                    'token'      => $token,
                    'client_key' => config('midtrans.client_key'),
                ]);
            }

            $errMessages = $respBody['error_messages'] ?? [$respBody['message'] ?? 'Unknown error'];
            Log::error("createSnap: Midtrans error {$status}", ['errors' => $errMessages, 'payload' => $payload]);
            return response()->json([
                'error'   => implode(', ', $errMessages),
                'status'  => $status,
            ], 500);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error("createSnap: connection failed - " . $e->getMessage());
            return response()->json([
                'error' => 'Tidak dapat terhubung ke Midtrans. Pastikan internet aktif dan server_key benar.',
            ], 503);
        } catch (\Throwable $e) {
            Log::error("createSnap: unexpected error - " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function notification(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;

        $signatureKey = hash('sha512',
            $orderId . ($payload['status_code'] ?? '') . ($payload['gross_amount'] ?? '') . $this->serverKey()
        );

        if ($signatureKey !== ($payload['signature_key'] ?? '')) {
            Log::warning('Midtrans invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Strip timestamp suffix jika ada (format: IB-XXXXXXXX-XXXXXX-1234567890)
        $orderNumber = preg_replace('/-\d{10}$/', '', $orderId);
        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? 'accept';

        if (($transactionStatus === 'capture' && $fraudStatus === 'accept') || $transactionStatus === 'settlement') {
            $order->update(['payment_status' => 'paid', 'midtrans_transaction_id' => $payload['transaction_id'] ?? null]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update(['payment_status' => 'failed', 'midtrans_snap_token' => null]);
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => 'pending']);
        }

        Log::info("Midtrans notification: order={$orderId} status={$transactionStatus}");
        return response()->json(['message' => 'OK']);
    }
}