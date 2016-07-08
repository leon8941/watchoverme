<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $lithium = \App\User::create([
            'name' => 'Lithium',
            'password' => \Illuminate\Support\Facades\Hash::make('12345'),
            'email' => 'lithiumbloodthirst@gmail.com'
        ]);
*/
        $souto = \App\User::create([
            'name' => 'kz',
            'password' => \Illuminate\Support\Facades\Hash::make('cracker0'),
            'email' => 'souto.victor@gmail.com'
        ]);
        
        //$this->call(UsersTableSeeder::class);
        //$this->call(PostsTableSeeder::class);
        //$this->call(GamersTableSeeder::class);
        //$this->call(EventsTableSeeder::class);
    }
}
