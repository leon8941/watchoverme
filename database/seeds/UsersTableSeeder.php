<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();

        $user1 = \App\User::create([
            'name'  => 'kz',
            'email' => 'souto.victor@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);
        $user2 = \App\User::create([
            'name'  => $faker->name,
            'email' => $faker->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);
        $user3 = \App\User::create([
            'name'  => $faker->name,
            'email' => $faker->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);
        $user4 = \App\User::create([
            'name'  => $faker->name,
            'email' => $faker->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);
        $user5 = \App\User::create([
            'name'  => $faker->name,
            'email' => $faker->email,
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);
    }
}
