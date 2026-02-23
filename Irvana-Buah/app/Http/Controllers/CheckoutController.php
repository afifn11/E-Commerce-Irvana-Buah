<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Proses checkout - buat order dari keranjang
     */
    public function process(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:1000',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cash',
            'notes'          => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi stok semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok ' . $item->product->name . ' tidak mencukupi. Tersedia: ' . $item->product->stock . ' kg.');
            }
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->effective_price;
        });

        DB::beginTransaction();
        try {
            // Buat order
            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_number'     => $this->generateOrderNumber(),
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'pending',
                'shipping_address' => $request->address,
                'shipping_phone'   => $request->phone,
                'notes'            => $request->notes,
            ]);

            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->effective_price,
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Halaman sukses setelah checkout
     */
    public function success(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.product', 'user']);

        return view('home.order-success', compact('order'));
    }

    /**
     * Generate nomor order unik
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'IB-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
