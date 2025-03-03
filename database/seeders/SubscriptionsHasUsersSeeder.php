<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsHasUsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscriptions_has_users')->insert([
            [
                'subscription_fk' => 1,
                'user_fk' => 2,
                'created_at' => '2025-02-26 00:17:16',
                'updated_at' => '2025-02-26 00:17:16',
            ],
        ]);
    }
}