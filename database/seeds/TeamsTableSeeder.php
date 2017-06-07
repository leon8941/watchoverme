<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $team = \App\Team::create([
            'title' => $faker->title,
            'owner_id' => '1',
            'description' => $faker->paragraph(3)
        ]);

        $team = \App\Team::create([
            'title' => $faker->title,
            'owner_id' => '2',
            'description' => $faker->paragraph(3)
        ]);
        $team = \App\Team::create([
            'title' => $faker->title,
            'owner_id' => '3',
            'description' => $faker->paragraph(3)
        ]);
        $team = \App\Team::create([
            'title' => $faker->title,
            'owner_id' => '4',
            'description' => $faker->paragraph(3)
        ]);

    }
}
