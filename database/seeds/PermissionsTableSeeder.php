<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createUser = new \App\Permission();
        $createUser->name = "create-user";
        $createUser->display_name = "Create User";
        $createUser->description = "create new users";
        $createUser->save();

        $createUser = new \App\Permission();
        $createUser->name = "update-user";
        $createUser->display_name = "Update User";
        $createUser->description = "update new users";
        $createUser->save();

        $createUser = new \App\Permission();
        $createUser->name = "delete-user";
        $createUser->display_name = "Delete User";
        $createUser->description = "delete new users";
        $createUser->save();
    }
}
