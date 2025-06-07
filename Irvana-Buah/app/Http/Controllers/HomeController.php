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
        
        // Mengambil semua kategori
        $categories = Category::orderBy('name')->get();
        
        // Mengambil produk unggulan (featured)
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->latest()
            ->limit(8)
            ->get();
        
        // Mengambil semua produk dengan pagination
        $allProducts = Product::with('category')
            ->active()
            ->inStock()
            ->latest()
            ->paginate(12);

        return view('home', compact(
            'setting',
            'categories', 
            'featuredProducts', 
            'allProducts'
        ));
    }

    public function products(Request $request)
    {
        // Pastikan $categories selalu tersedia
        $categories = Category::orderBy('name')->get();
        $setting = Setting::first();
        
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
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                // Urutkan berdasarkan jumlah penjualan (jika ada field sales_count)
                // $query->orderBy('sales_count', 'desc');
                $query->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(16);
        
        return view('products', compact('products', 'categories', 'setting'));
    }

    public function productDetail($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();
        
        // Produk terkait dari kategori yang sama
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();
        
        $setting = Setting::first();
        $categories = Category::orderBy('name')->get(); // Tambahkan ini jika diperlukan di view
        
        return view('product-detail', compact('product', 'relatedProducts', 'setting', 'categories'));
    }
    
    // Method tambahan untuk handling cart (jika diperlukan)
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login first']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Insufficient stock']);
        }

        // Add to cart logic here
        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            [
                'quantity' => \DB::raw('quantity + ' . $request->quantity)
            ]
        );

        return response()->json(['success' => true, 'message' => 'Product added to cart successfully']);
    }

    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}