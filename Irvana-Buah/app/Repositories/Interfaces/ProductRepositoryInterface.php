<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAllWithCategory(): Collection;
    public function getPaginatedWithCategory(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Product;
    public function findBySlug(string $slug): ?Product;
    public function getFeaturedActive(int $limit = 8): Collection;
    public function getTopSelling(int $limit = 5): Collection;
    public function getLowStock(int $threshold = 10, int $limit = 5): Collection;
    public function search(string $query, int $limit = 5): Collection;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product): bool;
}
