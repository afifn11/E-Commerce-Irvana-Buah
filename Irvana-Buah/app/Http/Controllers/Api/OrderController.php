<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        return Order::with('orderItems.product')->where('user_id', $userId)->get();
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;
        $data = $request->validate([
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $carts = Cart::where('user_id', $userId)->with('product')->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($carts as $cart) {
                $price = $cart->product->discount_price ?? $cart->product->price;
                $totalAmount += $price * $cart->quantity;
            }

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cash_on_delivery',
                'payment_status' => 'unpaid',
                'shipping_address' => $data['shipping_address'],
                'shipping_phone' => $data['shipping_phone'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($carts as $cart) {
                $price = $cart->product->discount_price ?? $cart->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $price,
                ]);
                // Update stock
                $cart->product->decrement('stock', $cart->quantity);
            }

            // Kosongkan cart setelah checkout
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return response()->json($order->load('orderItems.product'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, Order $order)
    {
        $userId = $request->user()->id;
        if ($order->user_id !== $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $order->load('orderItems.product');
    }

    public function update(Request $request, Order $order)
    {
        // Update hanya status & payment_status oleh admin saja, 
        // atau kamu bisa buat middleware role admin khusus.
        // Untuk contoh sederhana:
        $data = $request->validate([
            'status' => 'nullable|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|string',
        ]);
        $order->update($data);
        return response()->json($order);
    }

    public function destroy(Request $request, Order $order)
    {
        // Hapus order hanya jika status belum dikirim
        if (!in_array($order->status, ['pending', 'cancelled'])) {
            return response()->json(['message' => 'Cannot delete order at this stage'], 400);
        }
        $order->delete();
        return response()->json(null, 204);
    }
}
