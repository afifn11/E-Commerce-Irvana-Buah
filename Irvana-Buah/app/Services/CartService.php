<?php

namespace App\Services;

use App\DTO\CheckoutDTO;
use App\Exceptions\CartException;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {}

    public function getCartItems(int $userId): Collection
    {
        return $this->cartRepository->getCartWithProductsByUser($userId);
    }

    public function getTotalPrice(int $userId): float
    {
        return $this->cartRepository->getTotalPriceByUser($userId);
    }

    public function getCartCount(int $userId): int
    {
        return $this->cartRepository->getTotalQuantityByUser($userId);
    }

    /**
     * @throws CartException
     */
    public function addProduct(int $userId, int $productId, int $quantity): Cart
    {
        $product = Product::findOrFail($productId);

        if (! $product->is_active) {
            throw CartException::productInactive($product->name);
        }

        $existingCartItem = $this->cartRepository->findByUserAndProduct($userId, $productId);
        $totalQuantity    = $quantity + ($existingCartItem?->quantity ?? 0);

        if ($product->stock < $totalQuantity) {
            throw CartException::insufficientStock($product->name, $product->stock);
        }

        return $this->cartRepository->addOrUpdate($userId, $productId, $quantity);
    }

    /**
     * @throws CartException
     */
    public function updateQuantity(int $userId, int $cartItemId, int $quantity): Cart
    {
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->with('product')
            ->firstOrFail();

        if ($cartItem->product->stock < $quantity) {
            throw CartException::insufficientStock($cartItem->product->name, $cartItem->product->stock);
        }

        return $this->cartRepository->updateQuantity($cartItem, $quantity);
    }

    public function removeItem(int $userId, int $cartItemId): void
    {
        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $this->cartRepository->remove($cartItem);
    }

    public function clearCart(int $userId): void
    {
        $this->cartRepository->clearByUser($userId);
    }

    /**
     * Validate all cart items are purchasable.
     *
     * @throws CartException
     */
    public function validateForCheckout(int $userId): void
    {
        $cartItems = $this->cartRepository->getCartWithProductsByUser($userId);

        if ($cartItems->isEmpty()) {
            throw CartException::empty();
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                throw CartException::insufficientStock($item->product->name, $item->product->stock);
            }
        }
    }
}
