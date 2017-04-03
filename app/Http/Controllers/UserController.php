<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Traits\Solr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Renate\Timezones\Timezone;

class UserController extends Controller
{

    use Solr;

    public function hello() {
        // create a ping query
        $ping = $this->client->createPing();

        // execute the ping query
        $this->client->ping($ping);
        return response()->json(["Solr OK", $this->getUser(), Helper::getVersion(), Timezone::currentTimezone()]);
    }

}
