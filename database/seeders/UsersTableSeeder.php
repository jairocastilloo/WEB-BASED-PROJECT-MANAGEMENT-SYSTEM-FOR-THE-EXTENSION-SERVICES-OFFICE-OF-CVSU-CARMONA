<?php

namespace Database\Seeders;

use App\Models\Objective;
use App\Models\ProgramLeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectLeader;

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

        for ($i = 1; $i <= 500; $i++) {
            $excludeList = [
                10, 12, 18, 21, 24, 33, 35, 38, 57, 63, 64, 79, 80, 92, 93, 96, 99, 115, 116, 120, 125, 126, 132, 136, 141
            ];

            if (!in_array($i, $excludeList)) {
                $x =  $faker->numberBetween(1, 3);

                $yOptions = [645, 647, 649, 1, 2, 3, 4, 7, 9];

                for ($xx = 1; $xx <= $x; $xx++) {
                    // Choose a random element from the array
                    $key = array_rand($yOptions);
                    $y = $yOptions[$key];

                    // Remove the chosen element from the array
                    array_splice($yOptions, $key, 1);

                    ProgramLeader::create([
                        'project_id' => $i,
                        'user_id' => $y,
                    ]);
                }
            }
        }

        /*
        for ($i = 1; $i <= 500; $i++) {
            $x =  $faker->numberBetween(1, 4);

            for ($xx = 0; $xx <= $x; $xx++) {
                $y =  $faker->numberBetween(2, 4);
                for ($yy = 1; $yy <= $y; $yy++) {

                    Objective::create([
                        'name' => $faker->sentence($nbWords = 4),
                        'project_id' => $i,
                        'objectiveset_id' => $xx,
                    ]);
                }
            }
        }

*/

        /*
        for ($i = 0; $i < 500; $i++) {
            $project = new Project();
            $project->projecttitle = $faker->sentence(3);
            $project->programtitle = $faker->optional(0.8)->sentence(2); // 20% chance of being not null
            $project->projectstartdate = $faker->date('Y-m-d', '2023-08-31');
            $project->projectenddate = $faker->date('Y-m-d', '2024-08-30');
            $project->department = $faker->randomElement(['Department of Management', 'Department of Industrial and Information Technology', 'Department of Teacher Education', 'Department of Arts and Science']);
            $project->fiscalyear = $faker->randomElement([3, 4]);
            $project->projectstatus = 'Incomplete';
            $project->save();
        }

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
        */
    }
}
