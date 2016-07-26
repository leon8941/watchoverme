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
            'name'     => 'kz',
            'email'    => 'souto.victor@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('cracker0'),
        ]);

        $lithium = \App\User::create([
            'name' => 'Lithium',
            'password' => \Illuminate\Support\Facades\Hash::make('12345'),
            'email' => 'lithiumbloodthirst@gmail.com'
        ]);

        $inhouse_bot = \App\User::create([
            'id' => '666',
            'name' => 'InHouse Bot',
            'password' => \Illuminate\Support\Facades\Hash::make('12345'),
            'email' => 'staff@watchoverme.com.br'
        ]);
    }
}
