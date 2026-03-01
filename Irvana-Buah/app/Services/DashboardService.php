<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    private const CACHE_TTL    = 300; // 5 minutes
    private const CACHE_KEY    = 'dashboard_data';

    public function getStatistics(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, fn () => $this->buildStatistics());
    }

    public function refreshStatistics(): array
    {
        Cache::forget(self::CACHE_KEY);
        return $this->buildStatistics();
    }

    public function getStatsByDateRange(Carbon $startDate, Carbon $endDate): array
    {
        return [
            'orders'       => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'revenue'      => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
            'new_users'    => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_products' => Product::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    private function buildStatistics(): array
    {
        $now            = Carbon::now();
        $startOfMonth   = $now->copy()->startOfMonth();
        $startOfWeek    = $now->copy()->startOfWeek();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth   = $now->copy()->subMonth()->endOfMonth();

        return [
            // Product stats
            'totalProduk'       => Product::count(),
            'produkAktif'       => Product::where('is_active', true)->count(),
            'produkStokRendah'  => Product::where('stock', '<=', 10)->where('stock', '>', 0)->count(),
            'produkHabis'       => Product::where('stock', 0)->count(),
            'produkFeatured'    => Product::where('is_featured', true)->count(),

            // Category stats
            'totalKategori'     => Category::count(),

            // Order stats
            'totalPesanan'      => Order::count(),
            'pesananHariIni'    => Order::whereDate('created_at', $now->toDateString())->count(),
            'pesananMingguIni'  => Order::whereBetween('created_at', [$startOfWeek, $now])->count(),
            'pesananBulanIni'   => Order::whereBetween('created_at', [$startOfMonth, $now])->count(),
            'pesananPending'    => Order::where('status', 'pending')->count(),
            'pesananProses'     => Order::where('status', 'processing')->count(),
            'pesananSelesai'    => Order::where('status', 'delivered')->count(),
            'pesananBatal'      => Order::where('status', 'cancelled')->count(),

            // Revenue stats
            'totalRevenue'      => Order::where('payment_status', 'paid')->sum('total_amount'),
            'revenueHariIni'    => Order::where('payment_status', 'paid')
                ->whereDate('created_at', $now->toDateString())->sum('total_amount'),
            'revenueMingguIni'  => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfWeek, $now])->sum('total_amount'),
            'revenueBulanIni'   => Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $now])->sum('total_amount'),
            'pembayaranPending' => Order::where('payment_status', 'pending')->sum('total_amount'),

            // User stats
            'totalPengguna'     => User::count(),
            'penggunaAktif'     => User::whereNotNull('email_verified_at')->count(),
            'penggunaBaru'      => User::whereBetween('created_at', [$startOfWeek, $now])->count(),
            'adminCount'        => User::where('role', 'admin')->count(),

            // Lists
            'topProducts'       => $this->getTopProducts(),
            'topCategories'     => $this->getTopCategories(),
            'recentOrders'      => $this->getRecentOrders(),
            'lowStockProducts'  => $this->getLowStockProducts(),
            'recentActivities'  => $this->getRecentActivities(),

            // Growth
            'growthMetrics'     => $this->getGrowthMetrics(
                $startOfMonth, $now, $startOfLastMonth, $endOfLastMonth
            ),
        ];
    }

    private function getTopProducts(): \Illuminate\Support\Collection
    {
        return DB::table('order_items')
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
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(fn ($row) => (object) [
                'id'            => $row->id,
                'name'          => $row->name,
                'price'         => (float) $row->price,
                'total_sold'    => (int)   $row->total_sold,
                'total_revenue' => (float) $row->total_revenue,
            ]);
    }

    private function getTopCategories(): \Illuminate\Support\Collection
    {
        return DB::table('order_items')
            ->join('products',   'order_items.product_id',  '=', 'products.id')
            ->join('categories', 'products.category_id',   '=', 'categories.id')
            ->join('orders',     'order_items.order_id',   '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.payment_status', 'paid')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    }

    private function getRecentOrders(): \Illuminate\Support\Collection
    {
        return Order::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (Order $order) => [
                'id'               => $order->id,
                'order_number'     => $order->order_number,
                'customer'        => $order->user?->name ?? 'Guest',
                'customer_email'  => $order->user?->email ?? '-',
                'total'           => $order->total_amount,
                'status'          => $order->status instanceof \BackedEnum ? $order->status->value : (string) $order->status,
                'payment_status'  => $order->payment_status instanceof \BackedEnum ? $order->payment_status->value : (string) $order->payment_status,
                'created_at'      => $order->created_at->format('d M Y H:i'),
                'created_at_human' => $order->created_at->diffForHumans(),
            ]);
    }

    private function getLowStockProducts(): \Illuminate\Support\Collection
    {
        return Product::where('stock', '<=', 10)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->limit(5)
            ->get()
            ->map(fn (Product $product) => [
                'id'     => $product->id,
                'name'   => $product->name,
                'stock'  => $product->stock,
                'price'  => $product->price,
                'status' => $product->stock <= 5 ? 'critical' : 'warning',
            ]);
    }

    private function getRecentActivities(): \Illuminate\Support\Collection
    {
        $recentOrders = Order::with('user')->latest()->limit(3)->get()
            ->map(fn (Order $order) => [
                'type'        => 'order',
                'icon'        => 'shopping-bag',
                'color'       => 'blue',
                'title'       => 'Pesanan baru #' . $order->order_number,
                'description' => 'dari ' . ($order->user?->name ?? 'Guest'),
                'time'        => $order->created_at->diffForHumans(),
                'created_at'  => $order->created_at,
            ]);

        $recentProducts = Product::latest()->limit(2)->get()
            ->map(fn (Product $product) => [
                'type'        => 'product',
                'icon'        => 'package',
                'color'       => 'green',
                'title'       => 'Produk baru ditambahkan',
                'description' => $product->name,
                'time'        => $product->created_at->diffForHumans(),
                'created_at'  => $product->created_at,
            ]);

        $recentUsers = User::latest()->limit(2)->get()
            ->map(fn (User $user) => [
                'type'        => 'user',
                'icon'        => 'user-plus',
                'color'       => 'purple',
                'title'       => 'Pengguna baru bergabung',
                'description' => $user->name,
                'time'        => $user->created_at->diffForHumans(),
                'created_at'  => $user->created_at,
            ]);

        return collect()
            ->concat($recentOrders)
            ->concat($recentProducts)
            ->concat($recentUsers)
            ->sortByDesc('created_at')
            ->take(6)
            ->values();
    }

    private function getGrowthMetrics(
        Carbon $startOfMonth,
        Carbon $now,
        Carbon $startOfLastMonth,
        Carbon $endOfLastMonth
    ): array {
        $currentOrders  = Order::whereBetween('created_at', [$startOfMonth, $now])->count();
        $previousOrders = Order::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $currentRevenue  = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, $now])->sum('total_amount');
        $previousRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('total_amount');

        $currentUsers  = User::whereBetween('created_at', [$startOfMonth, $now])->count();
        $previousUsers = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        return [
            'orders'  => [
                'current'  => $currentOrders,
                'previous' => $previousOrders,
                'growth'   => $previousOrders > 0
                    ? round((($currentOrders - $previousOrders) / $previousOrders) * 100, 1)
                    : 0,
            ],
            'revenue' => [
                'current'  => $currentRevenue,
                'previous' => $previousRevenue,
                'growth'   => $previousRevenue > 0
                    ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
                    : 0,
            ],
            'users'   => [
                'current'  => $currentUsers,
                'previous' => $previousUsers,
                'growth'   => $previousUsers > 0
                    ? round((($currentUsers - $previousUsers) / $previousUsers) * 100, 1)
                    : 0,
            ],
        ];
    }
}
