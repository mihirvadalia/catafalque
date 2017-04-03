<?php

use Illuminate\Database\Seeder;

class RolesToPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Role::find(1)->attachPermission(1);
        App\Role::find(1)->attachPermission(2);
        App\Role::find(1)->attachPermission(3);
    }
}
