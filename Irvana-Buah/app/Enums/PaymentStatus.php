<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending  = 'pending';
    case Paid     = 'paid';
    case Failed   = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Menunggu Pembayaran',
            self::Paid     => 'Sudah Dibayar',
            self::Failed   => 'Gagal',
            self::Refunded => 'Dikembalikan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'warning',
            self::Paid     => 'success',
            self::Failed   => 'danger',
            self::Refunded => 'secondary',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
