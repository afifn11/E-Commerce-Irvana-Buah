<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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
        'price'          => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'stock'          => 'integer',
    ];

    // ---- Relationships ----

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    // ---- Scopes ----

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeBestSeller($query, int $limit = 10)
    {
        return $query
            ->withCount('orderItems as total_sold')
            ->withSum('orderItems as total_quantity', 'quantity')
            ->having('total_sold', '>', 0)
            ->orderByDesc('total_sold')
            ->limit($limit);
    }

    // ---- Accessors ----

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/default-product.png');
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->exists($this->image)
            ? Storage::url($this->image)
            : asset('images/default-product.png');
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function getHasDiscountAttribute(): bool
    {
        return ! is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (! $this->has_discount) {
            return 0;
        }

        return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPriceAttribute(): ?string
    {
        return $this->discount_price
            ? 'Rp ' . number_format((float) $this->discount_price, 0, ',', '.')
            : null;
    }

    public function getFormattedEffectivePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->effective_price, 0, ',', '.');
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at->diffInDays(now()) <= 7;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= 5 && $this->stock > 0;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) return 'out_of_stock';
        if ($this->stock <= 5) return 'low_stock';
        return 'in_stock';
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'Stok Habis',
            'low_stock'    => 'Stok Terbatas',
            default        => 'Stok Tersedia',
        };
    }

    // ---- Helpers ----

    public function hasImage(): bool
    {
        if (! $this->image) return false;
        if (filter_var($this->image, FILTER_VALIDATE_URL)) return true;
        return Storage::disk('public')->exists($this->image);
    }
}
