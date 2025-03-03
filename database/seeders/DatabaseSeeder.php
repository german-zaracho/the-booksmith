<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(SubscriptionsHasUsersSeeder::class);
    }
}
