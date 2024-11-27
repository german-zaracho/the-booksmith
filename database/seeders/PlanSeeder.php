<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('book_plans')->insert([
            [
                'book_plan_id' => 1,
                'total_price' => 30,
                'name' => 'Galactic Journeys',
                'description' => 'A plan designed for science fiction fans. Each month, you will receive three books that will take you to explore distant galaxies, dystopian futures, and advanced civilizations. Ideal for those who want to expand their imagination with fascinating worlds and technologies.',
                'month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_plan_id' => 2,
                'total_price' => 30,
                'name' => 'Hidden Truths',
                'description' => 'This thriller plan guarantees you three monthly books that will keep you in constant suspense. Each page is loaded with intrigue, unexpected twists and adrenaline. Perfect for those looking for strong emotions and shocking endings.',
                'month' => now(), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_plan_id' => 3,
                'total_price' => 30,
                'name' => 'Secret Passions',
                'description' => 'Romance takes over this plan. Three books selected especially for hopeless romantics, where stories of love and passion intertwine. Ideal for those who enjoy tender, intense stories full of emotions.',
                'month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_plan_id' => 4,
                'total_price' => 30,
                'name' => 'Mystery Reads',
                'description' => 'Do you love surprise? This plan is for you. Each month you will receive three completely different books, with varied themes, from fantasy to drama or mystery. The ideal plan for those who dare to discover something new every month.',
                'month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}