<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'ad@min.com',
                'password' => Hash::make('asdasd12'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $commonUserId = DB::table('users')->insertGetId([
            'name' => 'Common user',
            'email' => 'u@ser.com',
            'password' => Hash::make('asdasd12'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Obtener el primer plan de libros
        $bookPlan = DB::table('book_plans')->where('book_plan_id', 1)->first();

        // Crear la suscripción (dura 1 mes)
        $startDate = Carbon::now(); // Fecha de inicio: ahora
        $endDate = $startDate->copy()->addMonth(); // Fecha de fin: un mes después

        $subscriptionId = DB::table('subscriptions')->insertGetId([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true, // La suscripción está activa
            'book_plan_fk' => $bookPlan->book_plan_id, // Asignamos el primer plan
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asociar la suscripción al usuario comun en la tabla intermedia 'subscriptions_has_users'
        DB::table('subscriptions_has_users')->insert([
            'subscription_fk' => $subscriptionId,
            'user_fk' => $commonUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}

