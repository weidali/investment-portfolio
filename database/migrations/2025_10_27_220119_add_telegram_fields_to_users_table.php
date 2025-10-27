<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Добавляем поля для Telegram
            $table->bigInteger('telegram_id')->unique()->nullable()->after('id');
            $table->string('telegram_username')->nullable()->after('telegram_id');
            $table->string('timezone')->default('UTC')->after('telegram_username');
            $table->decimal('recommendation_threshold', 5, 2)->default(5.00)->after('timezone');
            $table->boolean('notifications_enabled')->default(true)->after('recommendation_threshold');
            
            // Добавляем индекс для telegram_id
            $table->index('telegram_id');
            
            // Делаем email nullable для Telegram пользователей
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Удаляем добавленные поля
            $table->dropColumn([
                'telegram_id',
                'telegram_username', 
                'timezone',
                'recommendation_threshold',
                'notifications_enabled'
            ]);
            
            // Возвращаем email и password к not null
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
