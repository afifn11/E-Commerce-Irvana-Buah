<?php

namespace App\DTO;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

readonly class ProductDTO
{
    public function __construct(
        public int     $categoryId,
        public string  $name,
        public float   $price,
        public ?float  $discountPrice,
        public int     $stock,
        public ?string $description,
        public bool    $isFeatured,
        public bool    $isActive,
        public ?string $slug = null,
        public ?string $imageUrl = null,
    ) {}

    public static function fromStoreRequest(StoreProductRequest $request): self
    {
        return new self(
            categoryId:    (int) $request->validated('category_id'),
            name:          $request->validated('name'),
            price:         (float) $request->validated('price'),
            discountPrice: $request->validated('discount_price') ? (float) $request->validated('discount_price') : null,
            stock:         (int) ($request->validated('stock') ?? 0),
            description:   $request->validated('description'),
            isFeatured:    $request->boolean('is_featured'),
            isActive:      $request->boolean('is_active'),
            slug:          $request->validated('slug'),
            imageUrl:      $request->validated('image_url'),
        );
    }

    public static function fromUpdateRequest(UpdateProductRequest $request): self
    {
        return new self(
            categoryId:    (int) $request->validated('category_id'),
            name:          $request->validated('name'),
            price:         (float) $request->validated('price'),
            discountPrice: $request->validated('discount_price') ? (float) $request->validated('discount_price') : null,
            stock:         (int) ($request->validated('stock') ?? 0),
            description:   $request->validated('description'),
            isFeatured:    $request->boolean('is_featured'),
            isActive:      $request->boolean('is_active'),
            slug:          $request->validated('slug'),
            imageUrl:      $request->validated('image_url'),
        );
    }
}
