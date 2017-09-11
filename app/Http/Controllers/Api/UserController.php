<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Solr\Cores\LarangCore;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $larangCore = app(LarangCore::class);
        $result = $larangCore->select($request->all(), [
            "responseType" => "result", // result or query
            "facets" => [
                "userEmail" => [
                    "type" => "list",
                    "field" => "userEmail",
                    "label" => "User Email"
                ],
                "userName" => [
                    "type" => "list",
                    "field" => "userName",
                    "label" => "User Name"
                ]
            ],
            "filter" => [
                "rowType" => "rowType:User"
            ],
            "search" => [
                "type" => "simple",
                "query" => 'searchTextUser:("*###SEARCHTERM###*")'
            ],
            "sort" => ["createdDate", "desc"]
        ]);
        $result['draw'] = $request->get('draw');
        return $this->response->array($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        User::create($request->all());

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        User::find($id)->update($request->all());

        return $this->response->created($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->response->accepted();
    }
}
