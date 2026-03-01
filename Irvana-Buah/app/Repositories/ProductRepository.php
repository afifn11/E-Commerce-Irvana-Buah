<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllWithCategory(): Collection
    {
        return Product::with('category')->latest()->get();
    }

    public function getPaginatedWithCategory(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with('category')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::with('category')->find($id);
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::with('category')->where('slug', $slug)->active()->first();
    }

    public function getFeaturedActive(int $limit = 8): Collection
    {
        return Product::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getTopSelling(int $limit = 5): Collection
    {
        return Product::with('category')
            ->active()
            ->withCount('orderItems as total_sold')
            ->withSum('orderItems as total_quantity', 'quantity')
            ->having('total_sold', '>', 0)
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getLowStock(int $threshold = 10, int $limit = 5): Collection
    {
        return Product::where('stock', '<=', $threshold)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit($limit)
            ->get();
    }

    public function search(string $query, int $limit = 5): Collection
    {
        return Product::with('category')
            ->active()
            ->inStock()
            ->where('name', 'like', "%{$query}%")
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->fresh();
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
