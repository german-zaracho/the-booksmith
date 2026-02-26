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
        Schema::create('orders_has_users', function (Blueprint $table) {

            $table->unsignedBigInteger('order_book_fk');
            $table->foreign('order_book_fk')->references('order_book_id')->on('order_books');

            $table->unsignedBigInteger('user_fk');
            $table->foreign('user_fk')->references('user_id')->on('users');

            $table->primary(['order_book_fk', 'user_fk']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_has_users');
    }
};
