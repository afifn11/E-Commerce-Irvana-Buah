<?php

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(
        private readonly ImageUploadService $imageUploadService,
    ) {}

    public function createCategory(CategoryDTO $categoryData, mixed $imageFile = null): Category
    {
        $data         = $this->prepareCategoryData($categoryData);
        $data['image'] = $this->resolveImage($categoryData, $imageFile);

        return Category::create($data);
    }

    public function updateCategory(Category $category, CategoryDTO $categoryData, mixed $imageFile = null): Category
    {
        $data          = $this->prepareCategoryData($categoryData);
        $resolvedImage = $this->resolveImage($categoryData, $imageFile, $category);

        if ($resolvedImage !== null) {
            $data['image'] = $resolvedImage;
        }

        $category->update($data);
        return $category->fresh();
    }

    public function deleteCategory(Category $category): void
    {
        $this->imageUploadService->deleteFile($category->image);
        $category->delete();
    }

    private function prepareCategoryData(CategoryDTO $dto): array
    {
        return [
            'name'        => $dto->name,
            'slug'        => $dto->slug ?? Str::slug($dto->name),
            'description' => $dto->description,
        ];
    }

    private function resolveImage(CategoryDTO $dto, mixed $imageFile, ?Category $existingCategory = null): ?string
    {
        if ($dto->imageType === 'file' && $imageFile) {
            if ($existingCategory) {
                $this->imageUploadService->deleteFile($existingCategory->image);
            }
            return $this->imageUploadService->uploadFile($imageFile, 'categories');
        }

        if ($dto->imageType === 'url' && $dto->imageUrl) {
            if ($existingCategory) {
                $this->imageUploadService->deleteFile($existingCategory->image);
            }
            return $this->imageUploadService->downloadFromUrl($dto->imageUrl, 'categories');
        }

        return null;
    }
}
