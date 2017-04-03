<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new App\User();
        $admin->name = "John Doe";
        $admin->email = "john@doe.com";
        $admin->password = Hash::make('12345678');
        $admin->save();

        $user = new App\User();
        $user->name = "Jack Doe";
        $user->email = "jack@doe.com";
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
