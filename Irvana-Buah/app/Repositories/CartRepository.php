<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartRepository implements CartRepositoryInterface
{
    public function getCartWithProductsByUser(int $userId): Collection
    {
        return Cart::with('product.category')
            ->where('user_id', $userId)
            ->get();
    }

    public function findByUserAndProduct(int $userId, int $productId): ?Cart
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public function getTotalPriceByUser(int $userId): float
    {
        return Cart::with('product')
            ->where('user_id', $userId)
            ->get()
            ->sum(fn (Cart $item) => $item->quantity * $item->product->effective_price);
    }

    public function getTotalQuantityByUser(int $userId): int
    {
        return (int) Cart::where('user_id', $userId)->sum('quantity');
    }

    public function addOrUpdate(int $userId, int $productId, int $quantity): Cart
    {
        $cartItem = $this->findByUserAndProduct($userId, $productId);

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
            return $cartItem->fresh();
        }

        return Cart::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'quantity'   => $quantity,
        ]);
    }

    public function updateQuantity(Cart $cartItem, int $quantity): Cart
    {
        $cartItem->update(['quantity' => $quantity]);
        return $cartItem->fresh();
    }

    public function remove(Cart $cartItem): bool
    {
        return $cartItem->delete();
    }

    public function clearByUser(int $userId): void
    {
        Cart::where('user_id', $userId)->delete();
    }
}
