<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class GamersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $gamer = \App\Gamer::create([
            'battletag' => 'kzz#1722',
            'user_id'   => '1'
        ]);
        $gamer = \App\Gamer::create([
            'battletag' => 'bellusci#8787',
            'user_id'   => '2'
        ]);
        $gamer = \App\Gamer::create([
            'battletag' => $faker->paragraph(1),
            'user_id'   => '3'
        ]);
        $gamer = \App\Gamer::create([
            'battletag' => $faker->paragraph(1),
            'user_id'   => '4'
        ]);

    }
}
