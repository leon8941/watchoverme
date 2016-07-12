<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $post = \App\Post::create([
            'title' => $faker->title,
            'text' => $faker->paragraph(8),
            'user_id' => '1'
        ]);
        $post = \App\Post::create([
            'title' => $faker->title,
            'text' => $faker->paragraph(8),
            'user_id' => '1'
        ]);
        $post = \App\Post::create([
            'title' => $faker->title,
            'text' => $faker->paragraph(8),
            'user_id' => '1'
        ]);
        $post = \App\Post::create([
            'title' => $faker->title,
            'text' => $faker->paragraph(8),
            'user_id' => '1'
        ]);

    }
}
