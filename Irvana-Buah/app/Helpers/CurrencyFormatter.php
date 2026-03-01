<?php

namespace App\Helpers;

class CurrencyFormatter
{
    public static function format(float|int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function parse(string $formatted): float
    {
        return (float) str_replace([',', '.', 'Rp ', ' '], ['', '', '', ''], $formatted);
    }
}
