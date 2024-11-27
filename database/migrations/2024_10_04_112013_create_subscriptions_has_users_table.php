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
        Schema::create('subscriptions_has_users', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_fk');
            $table->foreign('subscription_fk')->references('subscription_id')->on('subscriptions');

            $table->unsignedBigInteger('user_fk');
            $table->foreign('user_fk')->references('user_id')->on('users');

            $table->primary(['subscription_fk', 'user_fk']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions_has_users');
    }
};
