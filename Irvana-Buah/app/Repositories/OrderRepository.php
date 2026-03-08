<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function getPaginatedWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Order::with(['user', 'orderItems.product']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Order
    {
        return Order::with(['user', 'orderItems.product', 'coupon'])->find($id);
    }

    public function findByUserOrFail(int $orderId, int $userId): Order
    {
        return Order::with(['orderItems.product', 'user'])
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function getByUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with('orderItems.product')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function getStatistics(): array
    {
        // Keys disesuaikan dengan yang dipakai di orders/index.blade.php
        return [
            'total_orders'      => Order::count(),
            'pending_orders'    => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders'    => Order::where('status', 'shipped')->count(),
            'delivered_orders'  => Order::where('status', 'delivered')->count(),
            'cancelled_orders'  => Order::where('status', 'cancelled')->count(),
            'paid_orders'       => Order::where('payment_status', 'paid')->count(),
            'unpaid_orders'     => Order::where('payment_status', 'pending')->count(),
            'revenue'           => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order->fresh();
    }

    public function delete(Order $order): bool
    {
        return (bool) $order->delete();
    }
}
