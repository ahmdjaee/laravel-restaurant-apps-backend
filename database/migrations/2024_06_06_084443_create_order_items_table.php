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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id')->nullable(false);
            $table->foreignUlid('order_id')->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->bigInteger('price')->nullable(false);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
