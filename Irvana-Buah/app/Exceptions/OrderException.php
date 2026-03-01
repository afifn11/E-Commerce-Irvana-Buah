<?php

namespace App\Exceptions;

use Exception;

class OrderException extends Exception
{
    public static function notFound(): self
    {
        return new self('Pesanan tidak ditemukan.');
    }

    public static function unauthorized(): self
    {
        return new self('Anda tidak memiliki akses ke pesanan ini.');
    }
}
