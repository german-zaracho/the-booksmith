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
        Schema::create('buys_has_users', function (Blueprint $table) {

            $table->unsignedBigInteger('buy_fk');
            $table->foreign('buy_fk')->references('buy_id')->on('buys');

            $table->unsignedBigInteger('user_fk');
            $table->foreign('user_fk')->references('user_id')->on('users');

            $table->primary(['buy_fk', 'user_fk']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buys_has_users');
    }
};
