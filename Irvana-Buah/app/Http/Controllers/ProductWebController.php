<?php
// File: app/Http/Controllers/ProductWebController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductWebController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
        ]);

        // Handle image upload or URL
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName, 'public');
                $data['image'] = $imagePath;
                
                Log::info('Image uploaded: ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar.'])->withInput();
            }
        } elseif (!empty($data['image_url'])) {
            if ($this->validateImageUrl($data['image_url'])) {
                $data['image'] = $data['image_url'];
            } else {
                return back()->withErrors(['image_url' => 'URL gambar tidak dapat diakses.'])->withInput();
            }
        }

        unset($data['image_url']);

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['stock'] = $data['stock'] ?? 0;

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
        ]);

        if ($request->hasFile('image')) {
            try {
                $this->deleteOldImage($product);
                
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName, 'public');
                $data['image'] = $imagePath;
                
                Log::info('Image updated: ' . $imagePath);
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Gagal mengupload gambar.'])->withInput();
            }
        } elseif (!empty($data['image_url'])) {
            if ($this->validateImageUrl($data['image_url'])) {
                $this->deleteOldImage($product);
                $data['image'] = $data['image_url'];
            } else {
                return back()->withErrors(['image_url' => 'URL gambar tidak dapat diakses.'])->withInput();
            }
        }

        unset($data['image_url']);

        if (isset($data['name']) && $data['name'] !== $product->name && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
            
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['stock'] = $data['stock'] ?? 0;

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $this->deleteOldImage($product);
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Get image URL for display
     */
    public function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return null;
        }

        // Check if it's already a full URL
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // Check if file exists in storage
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::url($imagePath);
        }

        return null;
    }

    /**
     * Delete old image if it's a local file
     */
    private function deleteOldImage(Product $product)
    {
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
                Log::info('Old image deleted: ' . $product->image);
            }
        }
    }

    /**
     * Validate if image URL is accessible
     */
    private function validateImageUrl($url)
    {
        try {
            $headers = get_headers($url, 1);
            if (!$headers) return false;
            
            $httpCode = intval(substr($headers[0], 9, 3));
            
            if ($httpCode >= 200 && $httpCode < 300) {
                $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : '';
                if (is_array($contentType)) {
                    $contentType = $contentType[0];
                }
                return strpos($contentType, 'image/') === 0;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('URL validation failed: ' . $e->getMessage());
            return false;
        }
    }
}