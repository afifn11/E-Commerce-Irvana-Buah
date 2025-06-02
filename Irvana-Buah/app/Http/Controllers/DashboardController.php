<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache data untuk performa yang lebih baik (cache selama 5 menit)
        $dashboardData = Cache::remember('dashboard_data', 300, function () {
            return $this->getDashboardData();
        });

        return view('dashboard', $dashboardData);
    }

    /**
     * Get fresh dashboard data for AJAX updates
     */
    public function refreshStats()
    {
        Cache::forget('dashboard_data');
        $data = $this->getDashboardData();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Debug method untuk cek data dashboard
     */
    public function debugDashboard()
    {
        $data = $this->getDashboardData();
        
        // Debug untuk cek data
        dd([
            'totalRevenue' => $data['totalRevenue'],
            'revenueHariIni' => $data['revenueHariIni'],
            'revenueMingguIni' => $data['revenueMingguIni'],
            'revenueBulanIni' => $data['revenueBulanIni'],
            'topProducts' => $data['topProducts'],
            'recentOrders' => $data['recentOrders']
        ]);
    }

    /**
     * Get comprehensive dashboard data
     */
    private function getDashboardData()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();
        $yesterday = $now->copy()->subDay();

        return [
            // Statistik Utama
            'totalProduk' => Product::count(),
            'totalKategori' => Category::count(),
            'totalPesanan' => Order::count(),
            'totalPengguna' => User::count(),

            // Statistik Produk Detail
            'produkAktif' => Product::where('is_active', true)->count(),
            'produkStokRendah' => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
            'produkHabis' => Product::where('stock', 0)->count(),
            'produkFeatured' => Product::where('is_featured', true)->count(),

            // Statistik Pesanan Detail
            'pesananHariIni' => Order::whereDate('created_at', $now->toDateString())->count(),
            'pesananMingguIni' => Order::whereBetween('created_at', [$startOfWeek, $now])->count(),
            'pesananBulanIni' => Order::whereBetween('created_at', [$startOfMonth, $now])->count(),
            'pesananPending' => Order::where('status', 'pending')->count(),
            'pesananProses' => Order::where('status', 'processing')->count(),
            'pesananSelesai' => Order::where('status', 'delivered')->count(),
            'pesananBatal' => Order::where('status', 'cancelled')->count(),

            // Statistik Keuangan - DIPERBAIKI
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'revenueHariIni' => Order::where('payment_status', 'paid')
                ->whereDate('created_at', $now->toDateString())
                ->sum('total_amount'),
            'revenueMingguIni' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfWeek, $now])
                ->sum('total_amount'),
            'revenueBulanIni' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $now])
                ->sum('total_amount'),
            'pembayaranPending' => Order::where('payment_status', 'pending')->sum('total_amount'),

            // Statistik Pengguna
            'penggunaAktif' => User::where('email_verified_at', '!=', null)->count(),
            'penggunaBaru' => User::whereBetween('created_at', [$startOfWeek, $now])->count(),
            'adminCount' => User::where('role', 'admin')->count(),

            // Data untuk Lists
            'topProducts' => $this->getTopProducts(),
            'topCategories' => $this->getTopCategories(),
            'recentActivities' => $this->getRecentActivities(),
            'recentOrders' => $this->getRecentOrders(),
            'lowStockProducts' => $this->getLowStockProducts(),

            // Growth Metrics
            'growthMetrics' => $this->getGrowthMetrics(),
        ];
    }

    /**
     * Get top selling products - DIPERBAIKI dengan proper casting
     */
    private function getTopProducts()
    {
        $products = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.id',
                'products.name', 
                'products.price', 
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Convert ke Collection dengan proper casting
        return $products->map(function($product) {
            return (object) [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'total_sold' => (int) $product->total_sold,
                'total_revenue' => (float) $product->total_revenue
            ];
        });
    }

    /**
     * Get top categories by sales
     */
    private function getTopCategories()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.payment_status', 'paid') // Tambahkan kondisi ini
            ->select(
                'categories.id',
                'categories.name', 
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'icon' => 'shopping-bag',
                    'color' => 'blue',
                    'title' => 'Pesanan baru #' . $order->order_number,
                    'description' => 'dari ' . ($order->user ? $order->user->name : 'Guest'),
                    'time' => $order->created_at->diffForHumans(),
                    'created_at' => $order->created_at
                ];
            });

        // Recent products
        $recentProducts = Product::latest()
            ->limit(2)
            ->get()
            ->map(function ($product) {
                return [
                    'type' => 'product',
                    'icon' => 'package',
                    'color' => 'green',
                    'title' => 'Produk baru ditambahkan',
                    'description' => $product->name,
                    'time' => $product->created_at->diffForHumans(),
                    'created_at' => $product->created_at
                ];
            });

        // Recent users
        $recentUsers = User::latest()
            ->limit(2)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'icon' => 'user-plus',
                    'color' => 'purple',
                    'title' => 'Pengguna baru bergabung',
                    'description' => $user->name,
                    'time' => $user->created_at->diffForHumans(),
                    'created_at' => $user->created_at
                ];
            });

        return $activities
            ->concat($recentOrders)
            ->concat($recentProducts)
            ->concat($recentUsers)
            ->sortByDesc('created_at')
            ->take(6)
            ->values();
    }

    /**
     * Get recent orders
     */
    private function getRecentOrders()
    {
        return Order::with(['user'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->user ? $order->user->name : 'Guest',
                    'customer_email' => $order->user ? $order->user->email : $order->email ?? '-',
                    'total' => $order->total_amount,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at->format('d M Y H:i'),
                    'created_at_human' => $order->created_at->diffForHumans()
                ];
            });
    }

    /**
     * Get products with low stock
     */
    private function getLowStockProducts()
    {
        return Product::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock,
                    'price' => $product->price,
                    'status' => $product->stock <= 5 ? 'critical' : 'warning'
                ];
            });
    }

    /**
     * Get growth metrics compared to previous period
     */
    private function getGrowthMetrics()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $currentMonthOrders = Order::whereBetween('created_at', [$startOfMonth, $now])->count();
        $lastMonthOrders = Order::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        
        $currentMonthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->sum('total_amount');
        $lastMonthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_amount');

        $currentMonthUsers = User::whereBetween('created_at', [$startOfMonth, $now])->count();
        $lastMonthUsers = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        return [
            'orders' => [
                'current' => $currentMonthOrders,
                'previous' => $lastMonthOrders,
                'growth' => $lastMonthOrders > 0 ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0
            ],
            'revenue' => [
                'current' => $currentMonthRevenue,
                'previous' => $lastMonthRevenue,
                'growth' => $lastMonthRevenue > 0 ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0
            ],
            'users' => [
                'current' => $currentMonthUsers,
                'previous' => $lastMonthUsers,
                'growth' => $lastMonthUsers > 0 ? (($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0
            ]
        ];
    }

    /**
     * Get dashboard data for specific date range
     */
    public function getDataByDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $data = [
            'orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'revenue' => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_products' => Product::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}