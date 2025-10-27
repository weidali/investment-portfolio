<?php

namespace App\Enums;

enum RecommendationType: string
{
    case BUY = 'buy';
    case SELL = 'sell';

    public function label(): string
    {
        return match($this) {
            self::BUY => '🟢 Купить',
            self::SELL => '🔴 Продать',
        };
    }

    public function emoji(): string
    {
        return match($this) {
            self::BUY => '📈',
            self::SELL => '📉',
        };
    }
}
