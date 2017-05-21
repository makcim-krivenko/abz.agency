<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            'name'       => 'Big Boss',
        ]);

        DB::table('positions')->insert([
            'name'       => 'First level manager',
        ]);

        DB::table('positions')->insert([
            'name'       => 'Second level manager',
        ]);

        DB::table('positions')->insert([
            'name'       => 'Third level manager',
        ]);

        DB::table('positions')->insert([
            'name'       => 'Fourth level manager',
        ]);
    }
}
