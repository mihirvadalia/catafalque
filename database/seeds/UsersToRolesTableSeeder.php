<?php

use Illuminate\Database\Seeder;

class UsersToRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::find(1)->attachRole(1);
    }
}
