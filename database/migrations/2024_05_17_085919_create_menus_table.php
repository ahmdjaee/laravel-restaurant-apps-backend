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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->bigInteger('price')->unsigned()->nullable(false);
            $table->text('description')->nullable();
            $table->string('tags', 255)->nullable();
            $table->boolean('active')->nullable(false)->default(true);
            $table->integer('stock')->unsigned()->nullable(false);
            $table->string('image', 255)->nullable(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
