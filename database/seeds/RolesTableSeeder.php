<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = new App\Role();
        $adminRole->name = "admin";
        $adminRole->display_name = "System Administrator";
        $adminRole->description = "Root Administrator";
        $adminRole->save();
    }
}
