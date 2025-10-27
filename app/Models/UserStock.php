<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'quantity',
        'purchase_price',
        'purchase_date',
        'average_price',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'purchase_price' => 'decimal:4',
        'average_price' => 'decimal:4',
        'purchase_date' => 'date',
    ];

    // Связи
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    // Методы
    public function getCurrentPrice(): ?float
    {
        return $this->stock->currentPrice();
    }

    public function getTotalCost(): float
    {
        return (float)($this->quantity * $this->purchase_price);
    }

    public function getTotalValue(): float
    {
        $currentPrice = $this->getCurrentPrice();
        return $currentPrice ? (float)($this->quantity * $currentPrice) : 0;
    }

    public function getProfitLoss(): float
    {
        return $this->getTotalValue() - $this->getTotalCost();
    }

    public function getProfitLossPercent(): float
    {
        $totalCost = $this->getTotalCost();
        return $totalCost > 0 ? ($this->getProfitLoss() / $totalCost) * 100 : 0;
    }
}
