<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        //
        $event = \App\Event::create([
            'title' => $faker->title,
            'url' => $faker->url,
            'description' => $faker->paragraph(3),
            'starts' => $faker->dateTime,
            'streamer' => $faker->url,
            'from' => $faker->country,
            'cover' => $faker->url
        ]);

        $event = \App\Event::create([
            'title' => $faker->title,
            'url' => $faker->url,
            'description' => $faker->paragraph(3),
            'starts' => $faker->dateTime,
            'streamer' => $faker->url,
            'from' => $faker->country,
            'cover' => $faker->url
        ]);

        $event = \App\Event::create([
            'title' => $faker->title,
            'url' => $faker->url,
            'description' => $faker->paragraph(3),
            'starts' => $faker->dateTime,
            'streamer' => $faker->url,
            'from' => $faker->country,
            'cover' => $faker->url
        ]);
    }
}
