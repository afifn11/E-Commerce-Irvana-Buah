<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'image_type' => 'required|in:file,url',
            'description' => 'nullable|string',
        ]);

        // Generate slug jika tidak ada
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Handle image upload berdasarkan tipe
        $imagePath = $this->handleImageUpload($request, $data);
        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        // Remove fields yang tidak perlu disimpan di database
        unset($data['image_url'], $data['image_type']);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'image_type' => 'required|in:file,url',
            'description' => 'nullable|string',
        ]);

        // Generate slug jika kosong
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Handle image upload/update berdasarkan tipe
        $imagePath = $this->handleImageUpload($request, $data, $category);
        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        // Remove fields yang tidak perlu disimpan di database
        unset($data['image_url'], $data['image_type']);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Hapus gambar dari storage jika ada dan bukan URL eksternal
        if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Handle image upload dari file atau URL
     */
    private function handleImageUpload(Request $request, array $data, Category $category = null)
    {
        $imageType = $data['image_type'];

        if ($imageType === 'file' && $request->hasFile('image')) {
            // Upload dari file lokal
            return $this->handleFileUpload($request, $category);
        } elseif ($imageType === 'url' && !empty($data['image_url'])) {
            // Upload dari URL eksternal
            return $this->handleUrlUpload($data['image_url'], $category);
        }

        return null;
    }

    /**
     * Handle upload file lokal
     */
    private function handleFileUpload(Request $request, Category $category = null)
    {
        // Hapus gambar lama jika ada dan sedang update
        if ($category && $category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($category->image);
        }

        return $request->file('image')->store('categories', 'public');
    }

    /**
     * Handle upload dari URL eksternal
     */
    private function handleUrlUpload(string $url, Category $category = null)
    {
        try {
            // Validasi URL dan download gambar
            $response = Http::timeout(30)->get($url);
            
            if (!$response->successful()) {
                throw new \Exception('Gagal mengunduh gambar dari URL');
            }

            // Cek content type
            $contentType = $response->header('Content-Type');
            if (!str_starts_with($contentType, 'image/')) {
                throw new \Exception('URL bukan gambar yang valid');
            }

            // Generate nama file unik
            $extension = $this->getExtensionFromContentType($contentType);
            $fileName = 'categories/' . Str::random(40) . '.' . $extension;

            // Hapus gambar lama jika ada dan sedang update
            if ($category && $category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($category->image);
            }

            // Simpan gambar ke storage
            Storage::disk('public')->put($fileName, $response->body());

            return $fileName;

        } catch (\Exception $e) {
            // Jika gagal download, gunakan URL langsung
            return $url;
        }
    }

    /**
     * Get file extension from content type
     */
    private function getExtensionFromContentType(string $contentType): string
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        return $extensions[$contentType] ?? 'jpg';
    }

    /**
     * Validate image URL via AJAX
     */
    public function validateImageUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => 'URL tidak valid'
            ]);
        }

        try {
            $response = Http::timeout(10)->head($request->url);
            
            if (!$response->successful()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'URL tidak dapat diakses'
                ]);
            }

            $contentType = $response->header('Content-Type');
            if (!str_starts_with($contentType, 'image/')) {
                return response()->json([
                    'valid' => false,
                    'message' => 'URL bukan gambar yang valid'
                ]);
            }

            return response()->json([
                'valid' => true,
                'message' => 'URL gambar valid',
                'content_type' => $contentType
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Gagal memvalidasi URL: ' . $e->getMessage()
            ]);
        }
    }
}