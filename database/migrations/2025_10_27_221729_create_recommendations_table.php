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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_stock_id')->constrained('user_stocks')->onDelete('cascade');
            $table->enum('type', ['buy', 'sell']); // Рекомендация
            $table->decimal('current_price', 12, 4);
            $table->decimal('average_price', 12, 4);
            $table->decimal('threshold_percent', 5, 2);
            $table->boolean('notified')->default(false); // Отправили ли уведомление
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
