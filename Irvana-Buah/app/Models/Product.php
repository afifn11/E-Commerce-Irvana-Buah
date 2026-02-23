<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'discount_price',
        'stock',
        'image',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Accessor for image URL - PERBAIKAN UTAMA
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check if it's already a URL (starts with http/https)
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // If it's a file path, return the storage URL
            // Pastikan path tidak dimulai dengan slash ganda
            $imagePath = ltrim($this->image, '/');
            return asset('storage/' . $imagePath);
        }
        
        // Return default image if no image is set
        return asset('images/default-product.png');
    }

    // Method untuk mendapatkan full path gambar
    public function getFullImagePathAttribute()
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return storage_path('app/public/' . $this->image);
        }
        return null;
    }

    // Method untuk mengecek apakah gambar ada
    public function hasImage()
    {
        if (!$this->image) return false;
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return true; // Assume URL images exist
        }
        
        return file_exists(storage_path('app/public/' . $this->image));
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for products in stock
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Scope for best seller products
    public function scopeBestSeller($query, $limit = 10)
    {
        return $query->withCount('orderItems as total_sold')
                    ->withSum('orderItems as total_quantity', 'quantity')
                    ->having('total_sold', '>', 0)
                    ->orderBy('total_sold', 'desc')
                    ->orderBy('total_quantity', 'desc')
                    ->limit($limit);
    }

    // Get effective price (discount price if available, otherwise regular price)
    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Check if product has discount
    public function getHasDiscountAttribute()
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->has_discount) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    // Get total quantity sold
    public function getTotalSoldAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    // Get total revenue from this product
    public function getTotalRevenueAttribute()
    {
        return $this->orderItems()->sum(\DB::raw('quantity * price'));
    }

    // Check if product is best seller
    public function getIsBestSellerAttribute()
    {
        $totalSold = $this->total_sold;
        if ($totalSold === 0) return false;
        
        // Consider a product as best seller if it sold more than average
        $averageSales = Product::active()
                              ->whereHas('orderItems')
                              ->withCount('orderItems as sales_count')
                              ->avg('sales_count');
        
        return $totalSold > $averageSales;
    }

    // Get sales rank
    public function getSalesRankAttribute()
    {
        $higherSalesCount = Product::active()
                                  ->withCount('orderItems as total_sold')
                                  ->having('total_sold', '>', $this->total_sold)
                                  ->count();
        
        return $higherSalesCount + 1;
    }

    // Get product rating based on reviews (if you have reviews system)
    public function getAverageRatingAttribute()
    {
        // Assuming you have a reviews relationship
        // return $this->reviews()->avg('rating') ?? 0;
        
        // For now, return a mock rating based on sales
        $totalSold = $this->total_sold;
        if ($totalSold > 50) return 5.0;
        if ($totalSold > 30) return 4.5;
        if ($totalSold > 15) return 4.0;
        if ($totalSold > 5) return 3.5;
        return 3.0;
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Get formatted discount price
    public function getFormattedDiscountPriceAttribute()
    {
        return $this->discount_price ? 'Rp ' . number_format($this->discount_price, 0, ',', '.') : null;
    }

    // Get formatted effective price
    public function getFormattedEffectivePriceAttribute()
    {
        return 'Rp ' . number_format($this->effective_price, 0, ',', '.');
    }

    // Check if product is new (created within last 7 days)
    public function getIsNewAttribute()
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }

    // Check if stock is low
    public function getIsLowStockAttribute()
    {
        return $this->stock <= 5 && $this->stock > 0;
    }

    // Get stock status
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) return 'out_of_stock';
        if ($this->stock <= 5) return 'low_stock';
        return 'in_stock';
    }

    // Get stock status label
    public function getStockStatusLabelAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'Stok Habis';
            case 'low_stock':
                return 'Stok Terbatas';
            case 'in_stock':
            default:
                return 'Stok Tersedia';
        }
    }
}