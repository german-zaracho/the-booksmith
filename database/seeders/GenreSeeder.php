<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genres')->insert([
            [
                'genre_id' => 1,
                'name' => 'Terror',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 2,
                'name' => 'Adventure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 3,
                'name' => 'Juvenile',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 4,
                'name' => 'Warlike',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 5,
                'name' => 'Romance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 6,
                'name' => 'Science fiction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 7,
                'name' => 'Fantasy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 8,
                'name' => 'Historic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genre_id' => 9,
                'name' => 'Thriller',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
