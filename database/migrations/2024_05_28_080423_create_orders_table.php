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
            $table->ulid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('token')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->enum('status', ['new',  'checkout', 'paid', 'failed', 'completed'])->nullable()->default('new');
            $table->bigInteger('total_payment')->unsigned()->nullable()->default(12);
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('user_id')->references('id')->on('users');
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
