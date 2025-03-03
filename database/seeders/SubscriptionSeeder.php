<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscriptions_has_users')->delete();
        DB::table('subscriptions')->delete();
        DB::statement("ALTER TABLE subscriptions AUTO_INCREMENT = 1;");
        DB::table('subscriptions')->insert([
            [
                'subscription_id' => 1,
                'start_date' => '2025-02-26',
                'end_date' => '2025-02-26',
                'is_active' => 1,
                'book_plan_fk' => 1,
                'created_at' => '2025-02-26 00:17:16',
                'updated_at' => '2025-02-26 00:17:16',
            ],
        ]);
    }
}
