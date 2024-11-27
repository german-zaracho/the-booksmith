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
        Schema::create('order_books', function (Blueprint $table) {
            $table->id('order_book_id');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('price');

            $table->unsignedBigInteger('book_fk')->nullable();
            $table->foreign('book_fk')->references('book_id')->on('books');

            $table->unsignedBigInteger('buy_fk')->nullable();
            $table->foreign('buy_fk')->references('buy_id')->on('buys');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_books');
    }
};
