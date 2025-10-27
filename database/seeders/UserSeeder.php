<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['telegram_id' => 123456789], // Тестовый telegram_id
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'telegram_username' => 'test_user',
                'timezone' => 'UTC',
                'recommendation_threshold' => 5.00,
                'notifications_enabled' => true,
            ]
        );
    }
}
