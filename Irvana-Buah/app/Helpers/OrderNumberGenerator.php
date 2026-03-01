<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderNumberGenerator
{
    /**
     * Generate a unique order number with format IB-YYYYMMDD-XXXXXX
     */
    public static function generate(): string
    {
        do {
            $orderNumber = 'IB-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
