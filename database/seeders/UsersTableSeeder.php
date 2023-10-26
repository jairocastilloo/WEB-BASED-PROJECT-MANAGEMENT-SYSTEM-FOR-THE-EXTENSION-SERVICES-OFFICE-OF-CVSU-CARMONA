<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityUser;
use App\Models\Objective;
use App\Models\ProgramLeader;
use App\Models\ProjectUser;
use App\Models\Subtask;
use App\Models\SubtaskUser;
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

        for ($i = 1; $i <= 498; $i++) {

            $x = $faker->numberBetween(1, 3);

            $yOptions = [1, 2, 3, 4, 7, 9, 645, 647, 649];


            for ($xx = 1; $xx <= $x; $xx++) {
                // Choose a random element from the array
                $key = array_rand($yOptions);
                $y = $yOptions[$key];

                // Remove the chosen element from the array
                array_splice($yOptions, $key, 1);

                SubtaskUser::create([
                    'subtask_id' => $i,
                    'user_id' => $y,
                ]);
            }
        }
        /*
        for ($i = 2; $i < 500; $i++) {
            $subtasks = new Subtask();
            $subtasks->subtask_name = $faker->sentence(3);
            $subtasks->activity_id = $i;
            $startDate = strtotime('2022-01-01');
            $endDate = strtotime('2024-12-31');
            $randomStartTimestamp = mt_rand($startDate, $endDate);
            $subtasks->subduedate = date('Y-m-d', $randomStartTimestamp);
            $subtasks->status = $faker->randomElement(['Incomplete', 'Completed']);
            $subtasks->save();
        } */
        /*
        for ($i = 2; $i <= 500; $i++) {

            $x = $faker->numberBetween(1, 3);

            $yOptions = [1, 2, 3, 4, 7, 9, 645, 647, 649];


            for ($xx = 1; $xx <= $x; $xx++) {
                // Choose a random element from the array
                $key = array_rand($yOptions);
                $y = $yOptions[$key];

                // Remove the chosen element from the array
                array_splice($yOptions, $key, 1);

                ActivityUser::create([
                    'activity_id' => $i,
                    'user_id' => $y,
                ]);
            }
        }*/
        /*
        for ($i = 1; $i < 500; $i++) {
            $activity = new Activity();
            $activity->actname = $faker->sentence(3);
            $activity->actobjectives = $faker->randomElement([0, 1]);
            $activity->actoutput = $faker->sentence(2);
            $startDate = strtotime('2022-01-01');
            $endDate = strtotime('2024-12-31');
            $randomStartTimestamp = mt_rand($startDate, $endDate);

            // Generate a random end timestamp after the start date
            $randomEndTimestamp = mt_rand($randomStartTimestamp, $endDate);

            $activity->actstartdate = date('Y-m-d', $randomStartTimestamp);
            $activity->actenddate = date('Y-m-d', $randomEndTimestamp);
            $activity->actbudget = $faker->numberBetween($min = 1000, $max = 10000); // Adjust the range as needed
            $activity->actsource = $faker->sentence(2);
            $activity->project_id = $i;
            $activity->subtask = $faker->randomElement([0, 1]);
            $activity->actremark = $faker->randomElement(['Incomplete', 'Completed']);
            $activity->save();
        }
         */
        /*
        for ($i = 1; $i <= 500; $i++) {

            $x = $faker->numberBetween(1, 3);

            $yOptions = [645, 647, 649];

            for ($xx = 1; $xx <= $x; $xx++) {
                // Choose a random element from the array
                $key = array_rand($yOptions);
                $y = $yOptions[$key];

                // Remove the chosen element from the array
                array_splice($yOptions, $key, 1);

                ProjectUser::create([
                    'project_id' => $i,
                    'user_id' => $y,
                ]);
            }
        }
*/
        /*
        for ($i = 1; $i <= 500; $i++) {

            $x = $faker->numberBetween(1, 3);

            $yOptions = [1, 2, 3, 4, 7, 9];

            for ($xx = 1; $xx <= $x; $xx++) {
                // Choose a random element from the array
                $key = array_rand($yOptions);
                $y = $yOptions[$key];

                // Remove the chosen element from the array
                array_splice($yOptions, $key, 1);

                ProjectLeader::create([
                    'project_id' => $i,
                    'user_id' => $y,
                ]);
                ProjectUser::create([
                    'project_id' => $i,
                    'user_id' => $y,
                ]);
            }
        }
        */
        /*
        $excludeIds = [
            10, 12, 18, 21, 24, 33, 35, 38, 57, 63, 64, 79, 80, 92, 93, 96, 99, 115, 116, 120, 125, 126, 132, 136, 141, 154, 156, 164, 166, 169, 178, 181, 187, 192, 195, 200, 207, 208, 209, 216, 223, 225, 233, 243, 244, 245, 248, 258, 260, 266, 267, 270, 276, 283, 284, 287, 288, 296, 297, 308, 309, 314, 319, 322, 335, 341, 345, 358, 365, 367, 379, 381, 382, 392, 393, 394, 397, 402, 406, 418, 421, 434, 435, 436, 438, 442, 447, 448, 449, 454, 455, 456, 458, 459, 460, 467, 470, 473, 476, 479, 480, 482, 491, 496
        ];

        for ($i = 1; $i <= 500; $i++) {
            if (!in_array($i, $excludeIds)) {
                $x = $faker->numberBetween(1, 3);

                $yOptions = [1, 2, 3, 4, 7, 9];

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
*/

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
