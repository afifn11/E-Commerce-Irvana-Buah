<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    // ---- Relationships ----

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ---- Accessors ----

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) return null;

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->exists($this->image)
            ? Storage::url($this->image)
            : null;
    }

    // ---- Scopes ----

    public function scopeWithActiveProductCount($query)
    {
        return $query->withCount(['products' => fn ($q) => $q->active()->inStock()]);
    }
}
