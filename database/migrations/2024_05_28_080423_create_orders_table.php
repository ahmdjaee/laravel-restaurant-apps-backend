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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_item_id')->nullable(false);
            $table->unsignedBigInteger('reservation_id')->nullable(false);
            $table->bigInteger('total_payment')->nullable()->default(12);
            $table->timestamps();

            $table->foreign('cart_item_id')->references('id')->on('cart_items');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
