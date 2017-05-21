<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $boss_position         = \App\Position::where('name', 'Big Boss')->first();
        $first_level_position  = \App\Position::where('name', 'First level manager')->first();
        $second_level_position = \App\Position::where('name', 'Second level manager')->first();
        $third_level_position  = \App\Position::where('name', 'Third level manager')->first();
        $fourth_level_position = \App\Position::where('name', 'Fourth level manager')->first();

        $boss = new \App\Employee([
            'parent_id'   => '0',
            'position_id' => $boss_position->id,
            'full_name'   => $faker->name,
            'work_from'   => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
            'work_to'     => null,
            'salary'      => $faker->numberBetween($min = 3000, $max = 30000),
            'created_at'  => date('Y-m-d h:m:s'),
            'updated_at'  => date('Y-m-d h:m:s')
        ]);

        $boss->save();

        for ($first_level_records = 0; $first_level_records < 15; $first_level_records++) {
            $first_level_employee = new \App\Employee([
                'parent_id'   => $boss->id,
                'position_id' => $first_level_position->id,
                'full_name'   => $faker->name,
                'work_from'   => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
                'work_to'     => null,
                'salary'      => $faker->numberBetween($min = 3000, $max = 30000),
                'created_at'  => date('Y-m-d h:m:s'),
                'updated_at'  => date('Y-m-d h:m:s')
            ]);

            $first_level_employee->save();

            for ($second_level_records = 0; $second_level_records < 15; $second_level_records++) {
                $second_level_emploee = new \App\Employee([
                    'parent_id'   => $first_level_employee->id,
                    'position_id' => $second_level_position->id,
                    'full_name'   => $faker->name,
                    'work_from'   => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
                    'work_to'     => null,
                    'salary'      => $faker->numberBetween($min = 3000, $max = 30000),
                    'created_at'  => date('Y-m-d h:m:s'),
                    'updated_at'  => date('Y-m-d h:m:s')
                ]);

                $second_level_emploee->save();

                for ($third_level_records = 0; $third_level_records < 15; $third_level_records++) {
                    $third_level_emploee = new \App\Employee([
                        'parent_id'   => $second_level_emploee->id,
                        'position_id' => $third_level_position->id,
                        'full_name'   => $faker->name,
                        'work_from'   => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
                        'work_to'     => null,
                        'salary'      => $faker->numberBetween($min = 3000, $max = 30000),
                        'created_at'  => date('Y-m-d h:m:s'),
                        'updated_at'  => date('Y-m-d h:m:s')
                    ]);

                    $third_level_emploee->save();

                    for ($fourth_level_records = 0; $fourth_level_records < 15; $fourth_level_records++) {
                        $fourth_level_emploee = new \App\Employee([
                            'parent_id'   => $third_level_emploee->id,
                            'position_id' => $fourth_level_position->id,
                            'full_name'   => $faker->name,
                            'work_from'   => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now'),
                            'work_to'     => null,
                            'salary'      => $faker->numberBetween($min = 3000, $max = 30000),
                            'created_at'  => date('Y-m-d h:m:s'),
                            'updated_at'  => date('Y-m-d h:m:s')
                        ]);

                        $fourth_level_emploee->save();
                    }
                }
            }
        }
    }
}
