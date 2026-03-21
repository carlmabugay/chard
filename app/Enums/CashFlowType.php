<?php

namespace App\Enums;

enum CashFlowType: string
{
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromInput(string $value): self
    {
        return match ($value) {
            'withdraw' => self::WITHDRAW,
            default => self::DEPOSIT,
        };
    }
}
