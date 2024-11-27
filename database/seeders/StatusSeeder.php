<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            [
                'status_id' => 1,
                'name' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_id' => 2,
                'name' => 'Completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_id' => 3,
                'name' => 'Canceled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_id' => 4,
                'name' => 'Shiped',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
