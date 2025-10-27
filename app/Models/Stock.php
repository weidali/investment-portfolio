<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    protected $fillable = [
        'ticker',
        'name',
        'currency',
    ];

    public function userStocks(): HasMany
    {
        return $this->hasMany(UserStock::class);
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function currentPrice(): ?float
    {
        return Cache::remember(
            "stock.price.{$this->ticker}",
            3600,
            fn() => $this->priceHistory()
                ->latest('date')
                ->value('close')
        );
    }

    public function getPriceHistory(int $days = 30): array
    {
        return $this->priceHistory()
            ->where('date', '>=', now()->subDays($days))
            ->orderBy('date')
            ->get()
            ->pluck('close', 'date')
            ->toArray();
    }

    public static function findByTicker(string $ticker): ?self
    {
        return self::where('ticker', strtoupper($ticker))->first();
    }

    public static function firstOrCreateByTicker(string $ticker, string $name = null): self
    {
        return self::firstOrCreate(
            ['ticker' => strtoupper($ticker)],
            ['name' => $name ?? strtoupper($ticker), 'currency' => 'USD']
        );
    }
}
