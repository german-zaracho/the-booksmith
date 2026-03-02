<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('subscription_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active');
            $table->string('payment_method', 50)->default('mercadopago'); // 'mercadopago' | 'credit_card'
            $table->string('payment_status', 50)->default('completed');   // 'completed' | 'pending'

            $table->unsignedBigInteger('book_plan_fk')->nullable();
            $table->foreign('book_plan_fk')->references('book_plan_id')->on('book_plans');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
