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
}