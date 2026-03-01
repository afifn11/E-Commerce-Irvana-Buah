<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ImageUploadService         $imageUploadService,
    ) {}

    public function createProduct(ProductDTO $productData, mixed $imageFile = null): Product
    {
        $data = $this->prepareProductData($productData);

        if ($imageFile) {
            $data['image'] = $this->imageUploadService->uploadFile($imageFile, 'products');
        } elseif ($productData->imageUrl) {
            $data['image'] = $productData->imageUrl;
        }

        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, ProductDTO $productData, mixed $imageFile = null): Product
    {
        $data = $this->prepareProductData($productData);

        if ($imageFile) {
            $this->imageUploadService->deleteFile($product->image);
            $data['image'] = $this->imageUploadService->uploadFile($imageFile, 'products');
        } elseif ($productData->imageUrl) {
            $this->imageUploadService->deleteFile($product->image);
            $data['image'] = $productData->imageUrl;
        }

        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): void
    {
        $this->imageUploadService->deleteFile($product->image);
        $this->productRepository->delete($product);
    }

    private function prepareProductData(ProductDTO $dto): array
    {
        $slug = $dto->slug ?? $this->generateUniqueSlug($dto->name);

        return [
            'category_id'    => $dto->categoryId,
            'name'           => $dto->name,
            'slug'           => $slug,
            'price'          => $dto->price,
            'discount_price' => $dto->discountPrice,
            'stock'          => $dto->stock,
            'description'    => $dto->description,
            'is_featured'    => $dto->isFeatured,
            'is_active'      => $dto->isActive,
        ];
    }

    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug    = Str::slug($name);
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = Str::slug($name) . '-' . $counter++;
        }

        return $slug;
    }
}
