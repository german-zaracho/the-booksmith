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
        Schema::create('book_plan_books', function (Blueprint $table) {
            $table->unsignedBigInteger('book_plan_fk');
            $table->foreign('book_plan_fk')->references('book_plan_id')->on('book_plans');

            $table->unsignedBigInteger('book_fk');
            $table->foreign('book_fk')->references('book_id')->on('books');

            $table->primary(['book_plan_fk', 'book_fk']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_plan_books');
    }
};
