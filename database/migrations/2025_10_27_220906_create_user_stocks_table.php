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
        Schema::create('user_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade');
            $table->decimal('quantity', 12, 4); // кол-во акций (может быть дробным)
            $table->decimal('purchase_price', 12, 4); // цена одной акции в момент покупки
            $table->date('purchase_date');
            $table->decimal('average_price', 12, 4)->nullable(); // рассчитана автоматически
            $table->timestamps();
            
            $table->unique(['user_id', 'stock_id', 'purchase_date', 'purchase_price']);
            $table->index(['user_id', 'stock_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stocks');
    }
};
