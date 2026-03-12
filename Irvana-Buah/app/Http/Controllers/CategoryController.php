<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService     $categoryService,
        private readonly ImageUploadService  $imageUploadService,
    ) {}

    public function index(): View
    {
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $categoryData = CategoryDTO::fromStoreRequest($request);
        $this->categoryService->createCategory($categoryData, $request->file('image'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $categoryData = CategoryDTO::fromUpdateRequest($request);
        $this->categoryService->updateCategory($category, $categoryData, $request->file('image'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function validateImageUrl(Request $request): JsonResponse
    {
        $request->validate(['url' => ['required', 'url']]);

        $isValid = $this->imageUploadService->validateImageUrl($request->url);

        return response()->json([
            'valid'   => $isValid,
            'message' => $isValid ? 'URL gambar valid.' : 'URL tidak dapat diakses atau bukan gambar.',
        ]);
    }
}
