<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'max_discount',
        'usage_limit', 'usage_count', 'per_user_limit',
        'is_active', 'starts_at', 'expires_at', 'description',
    ];

    protected $casts = [
        'value'        => 'decimal:2',
        'min_order'    => 'decimal:2',
        'max_discount' => 'decimal:2',
        'is_active'    => 'boolean',
        'starts_at'    => 'datetime',
        'expires_at'   => 'datetime',
    ];

    public function usages(): HasMany { return $this->hasMany(CouponUsage::class); }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && Carbon::now()->lt($this->starts_at)) return false;
        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order) return 0;

        if ($this->type === 'percent') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount) $discount = min($discount, $this->max_discount);
            return $discount;
        }

        return min((float)$this->value, $subtotal);
    }

    public function usageCountByUser(int $userId): int
    {
        return $this->usages()->where('user_id', $userId)->count();
    }

    public function getFormattedValueAttribute(): string
    {
        return $this->type === 'percent'
            ? "{$this->value}%"
            : 'Rp ' . number_format($this->value, 0, ',', '.');
    }
}
