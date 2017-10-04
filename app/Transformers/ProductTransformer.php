<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

/**
 * Send selected fields in response
 * Class ProductTransformer
 * @package App\Transformers
 */

class ProductTransformer extends TransformerAbstract {

    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'upc' => $product->upc,
            'sku' => $product->sku,
            'ean' => $product->ean,
            'price' => $product->price,
            'saleprice' => $product->saleprice,
        ];
    }

}
