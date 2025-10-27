<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_stock_id',
        'type',
        'current_price',
        'average_price',
        'threshold_percent',
        'notified',
    ];

    protected $casts = [
        'current_price' => 'decimal:4',
        'average_price' => 'decimal:4',
        'threshold_percent' => 'decimal:2',
        'notified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userStock(): BelongsTo
    {
        return $this->belongsTo(UserStock::class);
    }
}
