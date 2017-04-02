<?php

use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OAuthClient::create([
        	'id' => 'fl7Zt77tTOV5mboL77L4j01422yFUrYd',
        	'secret' => '213395B6477F12A562A58D637156A',
        	'name' => 'SPA'
        ]);

        \App\OAuthClient::create([
        	'id' => 'Z0No4WEdFjwO9b4kaSQl8h6I89HHsznJ',
        	'secret' => 'C8CFB2B4E5AF77D7F49B638EDF896',
        	'name' => 'Android'
        ]);
    }
}
