<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Solr\Cores\LarangCore;
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
                "levelName" => [
                    "type" => "list",
                    "field" => "userEmail",
                    "label" => "User Email"
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
        return $this->response->array($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'email' => 'required',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
