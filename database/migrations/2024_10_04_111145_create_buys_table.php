<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id('buy_id');
            $table->decimal('total_price', 10, 2);
            $table->date('date');
            $table->string('payment_method', 50)->default('mercadopago');

            $table->unsignedBigInteger('status_fk')->nullable();
            $table->foreign('status_fk')->references('status_id')->on('status');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
