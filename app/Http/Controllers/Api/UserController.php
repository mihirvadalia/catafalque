<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\ApiController;
use App\Traits\File;
use App\Traits\Solr;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Renate\Timezones\Timezone;
use Spatie\Activitylog\Models\Activity;

class UserController extends ApiController
{

    use Solr, File;

    /**
     * @param Request $request
     * @return mixed
     */
    public function hello(Request $request) {
        dd(Activity::all());
        activity()->log('Look mum, I logged something');

        dd('done');
        $this->validate($request, [
            'avatar' => 'required'
        ]);

        // create a ping query
        $ping = $this->client->createPing();

        // execute the ping query
        $this->client->ping($ping);

        // File System
        $this->deleteAllImages('avatars/wkMmlcAKAK12d0rucQ6ca45XaTO9YbGAIfB34yEG.jpeg');
        $path = $this->storeFile($request, 'avatar', 'avatars');
        $this->resizeImage($path, 400);
        $this->resizeImage($path, 300);
        $this->resizeImage($path, 200);
        $this->resizeImage($path, 100);

        return response()->json([
            "solr" => "Solr OK",
            "user" => $this->getUser(),
            "version" => Helper::getVersion(),
            "timezone" => Timezone::currentTimezone(),
            "path" => $path
        ]);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function getList()
    {
        return $this->response->collection(User::all(), new UserTransformer);
    }

}
