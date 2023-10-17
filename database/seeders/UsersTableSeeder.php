<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;
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
        $faker = FakerFactory::create();

        for ($i = 0; $i < 500; $i++) {
            User::create([
                'username' => $faker->userName,
                'name' => $faker->firstName,
                'middle_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => $faker->randomElement(['Coordinator', 'Implementer']),
                'department' => $faker->randomElement([
                    'Department of Management',
                    'Department of Industrial and Information Technology',
                    'Department of Teacher Education',
                    'Department of Arts and Science'
                ]),
                'approval' => 1,
            ]);
        }
    }
}
