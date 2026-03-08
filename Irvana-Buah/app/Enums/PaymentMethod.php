<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Midtrans    = 'midtrans';       // Online via Midtrans Snap
    case Cash        = 'cash';           // COD

    public function label(): string
    {
        return match($this) {
            self::Midtrans    => 'Bayar Online (Midtrans)',
            self::Cash        => 'COD / Bayar di Tempat',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function isMidtrans(): bool { return $this === self::Midtrans; }
    public function isCOD(): bool      { return $this === self::Cash; }
}
