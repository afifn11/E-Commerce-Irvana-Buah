<?php

namespace App\Exceptions;

use Exception;

class CartException extends Exception
{
    public static function empty(): self
    {
        return new self('Keranjang belanja Anda kosong.');
    }

    public static function productInactive(string $productName): self
    {
        return new self("Produk '{$productName}' tidak tersedia saat ini.");
    }

    public static function insufficientStock(string $productName, int $available): self
    {
        return new self("Stok {$productName} tidak mencukupi. Stok tersedia: {$available} kg.");
    }
}
