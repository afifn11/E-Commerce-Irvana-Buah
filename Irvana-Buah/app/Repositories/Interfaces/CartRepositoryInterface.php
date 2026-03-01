<?php

namespace App\Repositories\Interfaces;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

interface CartRepositoryInterface
{
    public function getCartWithProductsByUser(int $userId): Collection;
    public function findByUserAndProduct(int $userId, int $productId): ?Cart;
    public function getTotalPriceByUser(int $userId): float;
    public function getTotalQuantityByUser(int $userId): int;
    public function addOrUpdate(int $userId, int $productId, int $quantity): Cart;
    public function updateQuantity(Cart $cartItem, int $quantity): Cart;
    public function remove(Cart $cartItem): bool;
    public function clearByUser(int $userId): void;
}
