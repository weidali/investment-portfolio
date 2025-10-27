<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['ticker' => 'AAPL', 'name' => 'Apple Inc.', 'currency' => 'USD'],
            ['ticker' => 'GOOGL', 'name' => 'Alphabet Inc.', 'currency' => 'USD'],
            ['ticker' => 'MSFT', 'name' => 'Microsoft Corporation', 'currency' => 'USD'],
            ['ticker' => 'AMZN', 'name' => 'Amazon.com Inc.', 'currency' => 'USD'],
            ['ticker' => 'TSLA', 'name' => 'Tesla Inc.', 'currency' => 'USD'],
            ['ticker' => 'META', 'name' => 'Meta Platforms Inc.', 'currency' => 'USD'],
            ['ticker' => 'NVDA', 'name' => 'NVIDIA Corporation', 'currency' => 'USD'],
        ];

        foreach ($stocks as $stock) {
            Stock::firstOrCreate(
                ['ticker' => $stock['ticker']],
                $stock
            );
        }
    }
}
