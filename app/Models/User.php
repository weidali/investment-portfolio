<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telegram_id',
        'telegram_username',
        'timezone',
        'recommendation_threshold',
        'notifications_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'recommendation_threshold' => 'decimal:2',
            'notifications_enabled' => 'boolean',
            
            'telegram_id' => 'integer',
            'recommendation_threshold' => 'decimal:2',
            'notifications_enabled' => 'boolean',
        ];
    }

    public function userStocks(): HasMany
    {
        return $this->hasMany(UserStock::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    // Методы
    public function getPortfolioValue(): float
    {
        return $this->userStocks()
            ->with('stock')
            ->get()
            ->sum(fn($us) => $us->quantity * ($us->stock->currentPrice() ?? 0));
    }

    public static function findByTelegramId(int $telegramId): ?self
    {
        return self::where('telegram_id', $telegramId)->first();
    }
}
