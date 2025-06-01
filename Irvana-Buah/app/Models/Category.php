<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Accessor untuk mendapatkan URL gambar lengkap
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Jika image adalah URL eksternal (dimulai dengan http/https)
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // Jika image adalah file lokal
            return asset('storage/' . $this->image);
        }
        return null;
    }

    // Accessor untuk cek apakah gambar adalah URL eksternal
    public function getIsExternalImageAttribute()
    {
        return $this->image && filter_var($this->image, FILTER_VALIDATE_URL);
    }

    // Accessor untuk mendapatkan nama file gambar saja
    public function getImageNameAttribute()
    {
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return basename(parse_url($this->image, PHP_URL_PATH));
            }
            return basename($this->image);
        }
        return null;
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }
}