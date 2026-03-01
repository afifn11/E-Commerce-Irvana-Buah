<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function getPaginatedWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Order;
    public function findByUserOrFail(int $orderId, int $userId): Order;
    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function getStatistics(): array;
    public function create(array $data): Order;
    public function update(Order $order, array $data): Order;
    public function delete(Order $order): bool;
}
