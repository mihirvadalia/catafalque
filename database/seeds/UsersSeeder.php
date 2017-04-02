<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
        	'name' => 'Mihir Vadalia',
        	'email' => 'mihirvadalia91@gmail.com',
        	'password' => Hash::make('secret')
        ]);
    }
}
