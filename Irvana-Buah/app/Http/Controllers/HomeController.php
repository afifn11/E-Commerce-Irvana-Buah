<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Cart; // Masih dibutuhkan untuk cart_count di compact pada index()
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil pengaturan website
        $setting = Setting::first();
        
        // Mengambil semua kategori buah
        $categories = Category::orderBy('name')->get();
        
        // Mengambil buah unggulan (featured)
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->latest()
            ->limit(8)
            ->get();
        
        // Mengambil semua produk buah dengan pagination
        $allProducts = Product::with('category')
            ->active()
            ->inStock()
            ->latest()
            ->paginate(12);

        // Statistik untuk homepage
        $stats = [
            'total_categories' => Category::count(),
            'total_products' => Product::active()->count(),
            'fresh_arrivals' => Product::active()->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('home', compact(
            'setting',
            'categories', 
            'featuredProducts', 
            'allProducts',
            'stats'
        ));
    }

    public function products(Request $request)
    {
        // Pastikan $categories selalu tersedia
        $categories = Category::orderBy('name')->get();
        $setting = Setting::first();
        
        $query = Product::with('category')->active()->inStock();
        
        // Filter berdasarkan kategori buah
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter berdasarkan pencarian nama buah
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filter berdasarkan harga buah
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where('price', '>=', $request->min_price)
                  ->orWhere('discount_price', '>=', $request->min_price);
            });
        }
        
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($subQ) use ($request) {
                    $subQ->whereNull('discount_price')
                         ->where('price', '<=', $request->max_price);
                })->orWhere(function($subQ) use ($request) {
                    $subQ->whereNotNull('discount_price')
                         ->where('discount_price', '<=', $request->max_price);
                });
            });
        }
        
        // Filter buah segar (produk terbaru dalam 7 hari)
        if ($request->filled('fresh_only') && $request->fresh_only == '1') {
            $query->where('created_at', '>=', now()->subDays(7));
        }
        
        // Filter buah diskon
        if ($request->filled('on_sale') && $request->on_sale == '1') {
            $query->whereNotNull('discount_price');
        }
        
        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                // Urutkan berdasarkan featured dan terbaru
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(16);
        
        // Tambahkan parameter pencarian ke pagination
        $products->appends($request->query());
        
        return view('products', compact('products', 'categories', 'setting'));
    }

    public function productDetail($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
        
        // Buah terkait dari kategori yang sama
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();
        
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        return view('product-detail', compact('product', 'relatedProducts', 'setting', 'categories'));
    }
    
    /**
     * Halaman About Us - Tentang Irvana Buah
     */
    public function about()
    {
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        return view('about', compact('setting', 'categories'));
    }
    
    /**
     * Halaman Contact - Kontak Irvana Buah
     */
    public function contact()
    {
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        return view('contact', compact('setting', 'categories'));
    }
    
    /**
     * Kirim pesan kontak
     */
    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Di sini Anda bisa menyimpan ke database atau kirim email
        // Untuk sekarang, kita hanya return success message
        
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
    
    /**
     * Search products via AJAX
     */
    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::with('category')
            ->active()
            ->inStock()
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->effective_price,
                    'formatted_price' => 'Rp ' . number_format($product->effective_price, 0, ',', '.'),
                    'image_url' => $product->image_url,
                    'category' => $product->category->name ?? '',
                ];
            });
        
        return response()->json($products);
    }
}