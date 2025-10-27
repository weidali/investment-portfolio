<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\User;
use App\Models\UserStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStockSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('telegram_id', 123456789)->first();

        if (!$user) {
            return;
        }

        $stocks = [
            ['ticker' => 'AAPL', 'quantity' => 10, 'purchase_price' => 150.50],
            ['ticker' => 'GOOGL', 'quantity' => 5, 'purchase_price' => 140.25],
            ['ticker' => 'MSFT', 'quantity' => 3, 'purchase_price' => 380.00],
        ];

        foreach ($stocks as $data) {
            $stock = Stock::where('ticker', $data['ticker'])->first();

            if ($stock) {
                UserStock::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'stock_id' => $stock->id,
                        'purchase_date' => now()->subDays(30)->toDateString(),
                        'purchase_price' => $data['purchase_price'],
                    ],
                    [
                        'quantity' => $data['quantity'],
                        'average_price' => $data['purchase_price'],
                    ]
                );
            }
        }
    }
}
