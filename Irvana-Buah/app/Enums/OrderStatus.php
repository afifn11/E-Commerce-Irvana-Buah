<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending    = 'pending';
    case Processing = 'processing';
    case Shipped    = 'shipped';
    case Delivered  = 'delivered';
    case Cancelled  = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Menunggu',
            self::Processing => 'Diproses',
            self::Shipped    => 'Dikirim',
            self::Delivered  => 'Selesai',
            self::Cancelled  => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending    => 'warning',
            self::Processing => 'info',
            self::Shipped    => 'primary',
            self::Delivered  => 'success',
            self::Cancelled  => 'danger',
        };
    }

    public function badgeClass(): string
    {
        return 'badge bg-' . $this->color();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
