<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            User::create([
                'id' => $faker->unique()->numberBetween(100000, 999999),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => $faker->randomElement(['Coordinator', 'Implementer']),
                'department' => $faker->randomElement(['IT', 'Sales', 'Marketing']),
            ]);
        }
    }
}
