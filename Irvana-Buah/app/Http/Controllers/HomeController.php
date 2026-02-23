<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil pengaturan website
        $setting = Setting::first();
        
        // Mengambil semua kategori buah dengan jumlah produk aktif
        $categories = Category::withCount(['products' => function($query) {
            $query->where('is_active', 1)->where('stock', '>', 0);
        }])
        ->having('products_count', '>', 0) // Hanya kategori yang memiliki produk
        ->orderBy('name')
        ->get();
        
        // Debug: Cek apakah ada produk featured
        \Log::info('Checking featured products...');
        
        // Mengambil buah unggulan (featured) dengan pengecekan null
        $featuredProducts = Product::with('category')
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->where('stock', '>', 0)
            ->latest()
            ->limit(8)
            ->get();
        
        // Debug log
        \Log::info('Featured products count: ' . $featuredProducts->count());
        
        // Jika tidak ada produk featured, ambil produk terbaru
        if ($featuredProducts->isEmpty()) {
            \Log::info('No featured products found, getting latest products...');
            $featuredProducts = Product::with('category')
                ->where('is_active', 1)
                ->where('stock', '>', 0)
                ->latest()
                ->limit(8)
                ->get();
        }
        
        // Mengambil produk Best Sellers berdasarkan total penjualan
        $bestSellerProducts = Product::with(['category', 'orderItems'])
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->withCount('orderItems as total_sold') // Hitung total item terjual
            ->withSum('orderItems as revenue', 'quantity') // Hitung total quantity terjual
            ->having('total_sold', '>', 0) // Hanya produk yang pernah terjual
            ->orderBy('total_sold', 'desc') // Urutkan berdasarkan total terjual
            ->orderBy('revenue', 'desc') // Urutkan berdasarkan revenue sebagai tiebreaker
            ->limit(4) // Tampilkan 4 produk best seller
            ->get();
        
        // Jika tidak ada produk yang terjual, ambil produk featured atau terbaru
        if ($bestSellerProducts->isEmpty()) {
            \Log::info('No best sellers found, getting featured or latest products...');
            $bestSellerProducts = Product::with('category')
                ->where('is_active', 1)
                ->where('stock', '>', 0)
                ->where(function($query) {
                    $query->where('is_featured', 1)
                          ->orWhereNull('is_featured'); // Include products without featured flag
                })
                ->latest()
                ->limit(4)
                ->get();
        }
        
        // Debug log untuk best sellers
        \Log::info('Best seller products count: ' . $bestSellerProducts->count());
        
        // Mengambil produk yang sedang diskon untuk hero section
        $discountedProducts = Product::with('category')
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->whereNotNull('discount_price')
            ->orderByRaw('((price - discount_price) / price) DESC') // Urutkan berdasarkan persentase diskon tertinggi
            ->limit(3) // Ambil 3 produk untuk ditampilkan di hero
            ->get();
        
        // Debug log untuk produk diskon
        \Log::info('Discounted products count: ' . $discountedProducts->count());
        
        // Mengambil semua produk buah dengan pagination
        $allProducts = Product::with('category')
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        // Statistik untuk homepage
        $stats = [
            'total_categories' => Category::count(),
            'total_products' => Product::where('is_active', 1)->count(),
            'fresh_arrivals' => Product::where('is_active', 1)->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Debug: Pastikan data sampai ke view
        \Log::info('Sending to view - Featured products: ' . $featuredProducts->count());
        \Log::info('Categories count: ' . $categories->count());
        \Log::info('Discounted products: ' . $discountedProducts->count());
        \Log::info('Best seller products: ' . $bestSellerProducts->count());

        return view('home', compact(
            'setting',
            'categories', 
            'featuredProducts', 
            'allProducts',
            'discountedProducts',
            'bestSellerProducts', // Tambahkan variabel best seller
            'stats'
        ));
    }

    public function products(Request $request)
{
    $setting = Setting::first();
    $categories = Category::withCount(['products' => function($query) {
        $query->active()->inStock();
    }])->orderBy('name')->get();

    // Dapatkan harga produk tertinggi untuk slider filter
    $maxPrice = Product::active()->max('price') ?? 1000000;

    $query = Product::with('category')->active()->inStock();
    
    // Filter berdasarkan kategori
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    
    // Filter berdasarkan pencarian
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }
    
    // Filter berdasarkan harga
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
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('created_at', 'desc');
            break;
        case 'newest':
        default:
            $query->latest();
            break;
    }
    
    $products = $query->paginate(12);
    $products->appends($request->query());
    
    return view('home.allproducts', compact('products', 'categories', 'setting', 'maxPrice'));
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
        
        return view('home.detail', compact('product', 'relatedProducts', 'setting', 'categories'));
    }

    /**
     * Tampilkan produk berdasarkan kategori
     */
    public function productsByCategory($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->active()
            ->inStock();
        
        // Filter berdasarkan pencarian nama buah
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
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
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(16);
        $products->appends($request->query());
        
        return view('category-products', compact('products', 'category', 'categories', 'setting'));
    }
    
    /**
     * Halaman About Us - Tentang Irvana Buah
     */
    public function about()
    {
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        return view('home.about', compact('setting', 'categories'));
    }
    
    /**
     * Halaman Contact - Kontak Irvana Buah
     */
    public function contact()
    {
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        return view('home.contact', compact('setting', 'categories'));
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

    /**
 * Halaman khusus produk diskon
 */
public function discountProducts(Request $request)
{
    $categories = Category::orderBy('name')->get();
    $setting = Setting::first();
    
    $query = Product::with('category')
        ->active()
        ->inStock()
        ->whereNotNull('discount_price');
    
    // Filter berdasarkan kategori
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    
    // Filter berdasarkan pencarian
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }
    
    // Filter berdasarkan persentase diskon minimum
    if ($request->filled('min_discount')) {
        $minDiscount = $request->min_discount;
        $query->whereRaw('((price - discount_price) / price * 100) >= ?', [$minDiscount]);
    }
    
    // Filter berdasarkan rentang harga diskon
    if ($request->filled('min_price')) {
        $query->where('discount_price', '>=', $request->min_price);
    }
    
    if ($request->filled('max_price')) {
        $query->where('discount_price', '<=', $request->max_price);
    }
    
    // Sorting
    switch ($request->sort) {
        case 'discount_high':
            // Urutkan berdasarkan persentase diskon tertinggi
            $query->orderByRaw('((price - discount_price) / price) DESC');
            break;
        case 'discount_low':
            // Urutkan berdasarkan persentase diskon terendah
            $query->orderByRaw('((price - discount_price) / price) ASC');
            break;
        case 'price_low':
            $query->orderBy('discount_price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('discount_price', 'desc');
            break;
        case 'savings_high':
            // Urutkan berdasarkan nominal penghematan tertinggi
            $query->orderByRaw('(price - discount_price) DESC');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'newest':
        default:
            $query->latest();
            break;
    }
    
    $products = $query->paginate(16);
    $products->appends($request->query());
    
    // Statistik diskon
    $discountStats = [
        'total_discount_products' => Product::active()->inStock()->whereNotNull('discount_price')->count(),
        'max_discount_percentage' => Product::active()->inStock()->whereNotNull('discount_price')
            ->selectRaw('MAX(((price - discount_price) / price * 100)) as max_discount')
            ->first()->max_discount ?? 0,
        'total_savings' => Product::active()->inStock()->whereNotNull('discount_price')
            ->selectRaw('SUM(price - discount_price) as total_savings')
            ->first()->total_savings ?? 0,
    ];
    
    return view('discount-products', compact('products', 'categories', 'setting', 'discountStats'));
}

    /**
     * Get discount statistics via AJAX
     */
    public function getDiscountStats()
    {
        $stats = [
            'total_discount_products' => Product::active()->inStock()->whereNotNull('discount_price')->count(),
            'categories_with_discounts' => Category::whereHas('products', function($query) {
                $query->active()->inStock()->whereNotNull('discount_price');
            })->count(),
            'average_discount_percentage' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('AVG(((price - discount_price) / price * 100)) as avg_discount')
                ->first()->avg_discount ?? 0,
            'biggest_savings' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('MAX(price - discount_price) as biggest_savings')
                ->first()->biggest_savings ?? 0,
        ];
        
        return response()->json($stats);
    }

    /**
     * Get trending discount products
     */
    public function getTrendingDiscounts()
    {
        $trendingDiscounts = Product::with('category')
            ->active()
            ->inStock()
            ->whereNotNull('discount_price')
            ->orderByRaw('((price - discount_price) / price) DESC') // Diskon terbesar
            ->limit(6)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category->name ?? '',
                    'original_price' => $product->price,
                    'discount_price' => $product->discount_price,
                    'discount_percentage' => $product->discount_percentage,
                    'savings' => $product->price - $product->discount_price,
                    'image_url' => $product->image_url,
                    'formatted_original_price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'formatted_discount_price' => 'Rp ' . number_format($product->discount_price, 0, ',', '.'),
                    'formatted_savings' => 'Rp ' . number_format($product->price - $product->discount_price, 0, ',', '.'),
                ];
            });
        
        return response()->json($trendingDiscounts);
    }


    /**
     * Halaman best seller products
     */
    public function bestSellerProducts(Request $request)
    {
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get();
        
        $query = Product::with(['category', 'orderItems'])
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->withCount('orderItems as total_sold')
            ->withSum('orderItems as total_quantity', 'quantity')
            ->orderBy('total_sold', 'desc');
        
        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->paginate(16);
        $products->appends($request->query());
        
        return view('best-sellers', compact('products', 'categories', 'setting'));
    }

    /**
     * Get best seller products via AJAX
     */
    public function getBestSellerProducts()
    {
        $bestSellers = Product::with(['category', 'orderItems'])
            ->where('is_active', 1)
            ->where('stock', '>', 0)
            ->withCount('orderItems as total_sold')
            ->withSum('orderItems as total_quantity', 'quantity')
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'desc')
            ->orderBy('total_quantity', 'desc')
            ->limit(8)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'category' => $product->category->name ?? '',
                    'price' => $product->price,
                    'discount_price' => $product->discount_price,
                    'effective_price' => $product->effective_price,
                    'has_discount' => $product->has_discount,
                    'discount_percentage' => $product->discount_percentage,
                    'image_url' => $product->image_url,
                    'total_sold' => $product->total_sold,
                    'total_quantity' => $product->total_quantity,
                    'formatted_price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'formatted_discount_price' => $product->discount_price ? 'Rp ' . number_format($product->discount_price, 0, ',', '.') : null,
                    'formatted_effective_price' => 'Rp ' . number_format($product->effective_price, 0, ',', '.'),
                ];
            });
        
        return response()->json($bestSellers);
    }
    
}