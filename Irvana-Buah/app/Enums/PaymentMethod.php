<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BankTransfer = 'bank_transfer';
    case EWallet      = 'e_wallet';
    case Cash         = 'cash';

    public function label(): string
    {
        return match($this) {
            self::BankTransfer => 'Transfer Bank',
            self::EWallet      => 'E-Wallet',
            self::Cash         => 'Tunai',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
