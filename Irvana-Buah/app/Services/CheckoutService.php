<?php

namespace App\Services;

use App\DTO\CheckoutDTO;
use App\Exceptions\CartException;
use App\Helpers\OrderNumberGenerator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $cartItems   = $this->cartRepository->getCartWithProductsByUser($userId);
        $totalAmount = $cartItems->sum(
            fn ($item) => $item->quantity * $item->product->effective_price
        );

        return DB::transaction(function () use ($userId, $checkoutData, $cartItems, $totalAmount) {
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

            $this->cartRepository->clearByUser($userId);

            Log::info("Order created: {$order->order_number} for user {$userId}");

            return $order;
        });
    }
}
