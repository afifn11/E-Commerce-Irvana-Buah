<?php

namespace App\DTO;

use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

readonly class CategoryDTO
{
    public function __construct(
        public string  $name,
        public ?string $description,
        public ?string $slug = null,
        public ?string $imageUrl = null,
        public ?string $imageType = null,
    ) {}

    public static function fromStoreRequest(StoreCategoryRequest $request): self
    {
        return new self(
            name:        $request->validated('name'),
            description: $request->validated('description'),
            slug:        $request->validated('slug'),
            imageUrl:    $request->validated('image_url'),
            imageType:   $request->validated('image_type'),
        );
    }

    public static function fromUpdateRequest(UpdateCategoryRequest $request): self
    {
        return new self(
            name:        $request->validated('name'),
            description: $request->validated('description'),
            slug:        $request->validated('slug'),
            imageUrl:    $request->validated('image_url'),
            imageType:   $request->validated('image_type'),
        );
    }
}
