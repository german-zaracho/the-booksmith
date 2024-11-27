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
        Schema::create('book_plans', function (Blueprint $table) {
            $table->id('book_plan_id');
            $table->unsignedInteger('total_price');
            $table->string('name', 100);
            $table->text('description');
            $table->date('month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_plans');
    }
};
