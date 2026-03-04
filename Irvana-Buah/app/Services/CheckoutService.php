<?php

namespace App\Services;

use App\DTO\CheckoutDTO;
use App\Exceptions\CartException;
use App\Helpers\OrderNumberGenerator;
use App\Mail\OrderStatusMail;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    public function __construct(
        private readonly CartService              $cartService,
        private readonly CartRepositoryInterface  $cartRepository,
    ) {}

    /**
     * @throws CartException|\Throwable
     */
    public function process(int $userId, CheckoutDTO $checkoutData): Order
    {
        $this->cartService->validateForCheckout($userId);

        $cartItems = $this->cartRepository->getCartWithProductsByUser($userId);
        $subtotal  = $cartItems->sum(fn($item) => $item->quantity * $item->product->effective_price);

        // Apply coupon if provided
        $coupon         = null;
        $discountAmount = 0;
        if (!empty($checkoutData->couponCode)) {
            $coupon = Coupon::where('code', strtoupper($checkoutData->couponCode))->first();
            if ($coupon && $coupon->isValid() && $coupon->usageCountByUser($userId) < $coupon->per_user_limit) {
                $discountAmount = $coupon->calculateDiscount($subtotal);
            }
        }
        $totalAmount = max(0, $subtotal - $discountAmount);

        return DB::transaction(function () use ($userId, $checkoutData, $cartItems, $totalAmount, $subtotal, $discountAmount, $coupon) {
            $order = Order::create([
                'user_id'          => $userId,
                'order_number'     => OrderNumberGenerator::generate(),
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
                'payment_method'   => $checkoutData->paymentMethod,
                'payment_status'   => 'pending',
                'shipping_address' => $checkoutData->address,
                'shipping_phone'   => $checkoutData->phone,
                'notes'            => $checkoutData->notes,
                'coupon_id'        => $coupon?->id,
                'discount_amount'  => $discountAmount,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->effective_price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Record coupon usage
            if ($coupon) {
                CouponUsage::create([
                    'coupon_id'       => $coupon->id,
                    'user_id'         => $userId,
                    'order_id'        => $order->id,
                    'discount_amount' => $discountAmount,
                ]);
                $coupon->increment('usage_count');
            }

            $this->cartRepository->clearByUser($userId);

            // Send order confirmation email
            try {
                $order->load(['orderItems.product', 'user']);
                Mail::to($order->user->email)->send(new OrderStatusMail($order));
            } catch (\Throwable $e) {
                Log::warning('Order confirmation mail failed: ' . $e->getMessage());
            }

            Log::info("Order created: {$order->order_number} for user {$userId}");

            return $order;
        });
    }
}
