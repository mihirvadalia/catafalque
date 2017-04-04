<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Traits\Solr;
use App\Transformers\UserTransformer;
use App\User;
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
        return response()->json([
            "solr" => "Solr OK",
            "user" => $this->getUser(),
            "version" => Helper::getVersion(),
            "timezone" => Timezone::currentTimezone()
        ]);
    }

    public function getList()
    {
        return $this->response->collection(User::all(), new UserTransformer);
    }

}
