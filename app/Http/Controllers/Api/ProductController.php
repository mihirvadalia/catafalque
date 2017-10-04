<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Solr\Cores\LarangCore;
use App\Transformers\ProductTransformer;
use App\Product;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use LaravelArdent\Ardent\Ardent;

class ProductController extends ApiController
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
                "productEmail" => [
                    "type" => "list",
                    "field" => "productName",
                    "label" => "Product Name"
                ],
            ],
            "filter" => [
                "rowType" => "rowType:Product"
            ],
            "search" => [
                "type" => "simple",
                "query" => 'searchTextProduct:("*###SEARCHTERM###*")'
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
        $product = new Product();
        $product->name = Input::get('name');
        $product->upc = Input::get('upc');
        $product->sku = Input::get('sku');
        $product->ean = Input::get('ean');
        $product->price = Input::get('price');
        $product->saleprice = Input::get('saleprice');
        //$product = Product::create($request->all());
        if(!$product->save()) {
            $this->throwArdentException($product->errors());
        }

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
        $product = Product::findOrFail($id);

        return $this->response->item($product, new ProductTransformer());
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
        Product::find($id)->update($request->all());

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
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
