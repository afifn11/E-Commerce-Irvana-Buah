<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function index(): View
    {
        $setting  = Setting::first();
        $categories = Category::withActiveProductCount()
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        $featuredProducts = $this->productRepository->getFeaturedActive(8);

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')->active()->inStock()->latest()->limit(8)->get();
        }

        $bestSellerProducts = $this->productRepository->getTopSelling(4);

        if ($bestSellerProducts->isEmpty()) {
            $bestSellerProducts = Product::with('category')->active()->inStock()->featured()->latest()->limit(4)->get();
        }

        $discountedProducts = Product::with('category')
            ->active()->inStock()
            ->whereNotNull('discount_price')
            ->orderByRaw('((price - discount_price) / price) DESC')
            ->limit(3)
            ->get();

        // allProducts now loaded via AJAX per category (see getProductsByCategoryJson)

        $stats = [
            'total_categories' => Category::count(),
            'total_products'   => Product::where('is_active', true)->count(),
            'fresh_arrivals'   => Product::active()->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('home', compact(
            'setting', 'categories', 'featuredProducts',
            'discountedProducts', 'bestSellerProducts', 'stats'
        ));
    }

    public function products(Request $request): View
    {
        $setting    = Setting::first();
        $categories = Category::withCount(['products' => fn ($q) => $q->active()->inStock()])->orderBy('name')->get();
        $maxPrice   = Product::active()->max('price') ?? 1000000;

        $query = Product::with('category')->active()->inStock();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where(fn ($q) => $q
                ->where(fn ($sub) => $sub->whereNull('discount_price')->where('price', '<=', $request->max_price))
                ->orWhere(fn ($sub) => $sub->whereNotNull('discount_price')->where('discount_price', '<=', $request->max_price))
            );
        }

        $this->applySorting($query, $request->sort);

        $products = $query->paginate(12)->appends($request->query());

        return view('home.allproducts', compact('products', 'categories', 'setting', 'maxPrice'));
    }

    public function productDetail(string $slug): View
    {
        $product = Product::with('category')->where('slug', $slug)->active()->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()->inStock()
            ->limit(4)->get();

        $setting    = Setting::first();
        $categories = Category::orderBy('name')->get();

        return view('home.detail', compact('product', 'relatedProducts', 'setting', 'categories'));
    }

    public function productsByCategory(string $slug, Request $request): View
    {
        $category   = Category::where('slug', $slug)->firstOrFail();
        $setting    = Setting::first();
        $categories = Category::orderBy('name')->get();

        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->active()->inStock();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        $this->applySorting($query, $request->sort);

        $products = $query->paginate(16)->appends($request->query());

        return view('category-products', compact('products', 'category', 'categories', 'setting'));
    }

    public function about(): View
    {
        $setting    = Setting::first();
        $categories = Category::orderBy('name')->get();

        return view('home.about', compact('setting', 'categories'));
    }

    public function contact(): View
    {
        $setting    = Setting::first();
        $categories = Category::orderBy('name')->get();

        return view('home.contact', compact('setting', 'categories'));
    }

    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    public function searchProducts(Request $request): JsonResponse
    {
        $query = $request->get('query', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = $this->productRepository->search($query)
            ->map(fn (Product $product) => [
                'id'              => $product->id,
                'name'            => $product->name,
                'slug'            => $product->slug,
                'price'           => $product->effective_price,
                'formatted_price' => $product->formatted_effective_price,
                'image_url'       => $product->image_url,
                'category'        => $product->category?->name ?? '',
            ]);

        return response()->json($products);
    }

    public function discountProducts(Request $request): View
    {
        $categories = Category::orderBy('name')->get();
        $setting    = Setting::first();

        $query = Product::with('category')->active()->inStock()->whereNotNull('discount_price');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        if ($request->filled('min_discount')) {
            $query->whereRaw('((price - discount_price) / price * 100) >= ?', [$request->min_discount]);
        }

        switch ($request->sort) {
            case 'discount_high': $query->orderByRaw('((price - discount_price) / price) DESC'); break;
            case 'discount_low':  $query->orderByRaw('((price - discount_price) / price) ASC'); break;
            case 'price_low':     $query->orderBy('discount_price', 'asc'); break;
            case 'price_high':    $query->orderBy('discount_price', 'desc'); break;
            case 'savings_high':  $query->orderByRaw('(price - discount_price) DESC'); break;
            default:              $query->latest(); break;
        }

        $products      = $query->paginate(16)->appends($request->query());
        $discountStats = $this->getDiscountStats();

        return view('discount-products', compact('products', 'categories', 'setting', 'discountStats'));
    }

    public function getDiscountStatsJson(): JsonResponse
    {
        return response()->json($this->getDiscountStats());
    }

    public function getTrendingDiscounts(): JsonResponse
    {
        $trendingDiscounts = Product::with('category')
            ->active()->inStock()->whereNotNull('discount_price')
            ->orderByRaw('((price - discount_price) / price) DESC')
            ->limit(6)->get()
            ->map(fn (Product $product) => [
                'id'                       => $product->id,
                'name'                     => $product->name,
                'slug'                     => $product->slug,
                'category'                 => $product->category?->name ?? '',
                'original_price'           => $product->price,
                'discount_price'           => $product->discount_price,
                'discount_percentage'      => $product->discount_percentage,
                'savings'                  => $product->price - $product->discount_price,
                'image_url'                => $product->image_url,
                'formatted_original_price' => $product->formatted_price,
                'formatted_discount_price' => $product->formatted_discount_price,
                'formatted_savings'        => 'Rp ' . number_format($product->price - $product->discount_price, 0, ',', '.'),
            ]);

        return response()->json($trendingDiscounts);
    }

    public function bestSellerProducts(Request $request): View
    {
        $setting    = Setting::first();
        $categories = Category::orderBy('name')->get();

        $query = Product::with(['category', 'orderItems'])
            ->active()->inStock()
            ->withCount('orderItems as total_sold')
            ->withSum('orderItems as total_quantity', 'quantity');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        match ($request->sort) {
            'price_low'  => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'newest'     => $query->orderByDesc('created_at'),
            default      => $query->orderByDesc('total_sold'),
        };

        $products = $query->paginate(16)->appends($request->query());

        return view('best-sellers', compact('products', 'categories', 'setting'));
    }

    public function getProductsByCategoryJson(Request $request): JsonResponse
    {
        $categoryId = $request->get('category_id');
        $limit      = (int) $request->get('limit', 8);

        $query = Product::with('category')->active()->inStock()->latest();

        if ($categoryId && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        $products = $query->limit($limit)->get()->map(fn (Product $p) => [
            'id'                  => $p->id,
            'name'                => $p->name,
            'slug'                => $p->slug,
            'image_url'           => $p->image_url,
            'category_name'       => $p->category?->name ?? '',
            'category_slug'       => $p->category?->slug ?? '',
            'price'               => $p->price,
            'discount_price'      => $p->discount_price,
            'has_discount'        => $p->has_discount,
            'discount_percentage' => $p->discount_percentage,
            'stock'               => $p->stock,
            'stock_status'        => $p->stock_status,
            'is_new'              => $p->is_new,
            'is_low_stock'        => $p->is_low_stock,
            'detail_url'          => route('product.detail', $p->slug),
            'category_url'        => $p->category ? route('products.by.category', $p->category->slug) : '#',
            'formatted_price'             => 'Rp ' . number_format((float)$p->price, 0, ',', '.'),
            'formatted_discount_price'    => $p->discount_price ? 'Rp ' . number_format((float)$p->discount_price, 0, ',', '.') : null,
        ]);

        return response()->json(['products' => $products]);
    }

    public function getBestSellerProductsJson(): JsonResponse
    {
        $bestSellers = $this->productRepository->getTopSelling(8)
            ->map(fn (Product $product) => [
                'id'                       => $product->id,
                'name'                     => $product->name,
                'slug'                     => $product->slug,
                'category'                 => $product->category?->name ?? '',
                'price'                    => $product->price,
                'discount_price'           => $product->discount_price,
                'effective_price'          => $product->effective_price,
                'has_discount'             => $product->has_discount,
                'discount_percentage'      => $product->discount_percentage,
                'image_url'                => $product->image_url,
                'total_sold'               => $product->total_sold ?? 0,
                'formatted_price'          => $product->formatted_price,
                'formatted_discount_price' => $product->formatted_discount_price,
                'formatted_effective_price' => $product->formatted_effective_price,
            ]);

        return response()->json($bestSellers);
    }

    // ---- Private Helpers ----

    private function applySorting($query, ?string $sort): void
    {
        match($sort) {
            'price_low'  => $query->orderByRaw('COALESCE(discount_price, price) ASC'),
            'price_high' => $query->orderByRaw('COALESCE(discount_price, price) DESC'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'name_desc'  => $query->orderBy('name', 'desc'),
            'popular'    => $query->orderByDesc('is_featured')->latest(),
            default      => $query->latest(),
        };
    }

    private function getDiscountStats(): array
    {
        return [
            'total_discount_products' => Product::active()->inStock()->whereNotNull('discount_price')->count(),
            'categories_with_discounts' => Category::whereHas('products', fn ($q) =>
                $q->active()->inStock()->whereNotNull('discount_price')
            )->count(),
            'average_discount_percentage' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('AVG(((price - discount_price) / price * 100)) as avg_discount')
                ->first()->avg_discount ?? 0,
            'biggest_savings' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('MAX(price - discount_price) as biggest_savings')
                ->first()->biggest_savings ?? 0,
            'max_discount_percentage' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('MAX((price - discount_price) / price * 100) as max_discount')
                ->first()->max_discount ?? 0,
            'total_savings' => Product::active()->inStock()->whereNotNull('discount_price')
                ->selectRaw('SUM(price - discount_price) as total_savings')
                ->first()->total_savings ?? 0,
        ];
    }
}
