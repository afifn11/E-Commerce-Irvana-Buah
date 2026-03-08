<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'shipping_phone',
        'notes',
        // Coupon
        'coupon_id',
        'discount_amount',
        // Points
        'points_redeemed',
        'points_earned',
        // Midtrans
        'midtrans_snap_token',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'total_amount'   => 'decimal:2',
        'status'         => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    // ---- Relationships ----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function couponUsage(): HasOne
    {
        return $this->hasOne(CouponUsage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ---- Scopes ----

    public function scopePaid($query)
    {
        return $query->where('payment_status', PaymentStatus::Paid);
    }

    public function scopePending($query)
    {
        return $query->where('status', OrderStatus::Pending);
    }

    // ---- Accessors ----

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status instanceof OrderStatus
            ? $this->status->label()
            : ucfirst($this->status ?? '');
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status instanceof OrderStatus
            ? $this->status->color()
            : 'secondary';
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return $this->payment_status instanceof PaymentStatus
            ? $this->payment_status->label()
            : ucfirst($this->payment_status ?? '');
    }
}
