<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MatchsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $match = \App\Match::create([
            'user_id' => '2',
            'status'    => '1',
        ]);

        $match = \App\Match::create([
            'user_id' => '1',
            'status'    => '1',
        ]);

        $match = \App\Match::create([
            'user_id' => '2',
            'status'    => '2',
        ]);

        $match = \App\Match::create([
            'user_id' => '2',
            'status'    => '3',
        ]);

        $match = \App\Match::create([
            'user_id' => '2',
            'status'    => '4',
        ]);


    }
}
