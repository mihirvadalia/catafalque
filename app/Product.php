<?php

namespace App;

use App\Solr\Cores\LarangCore;
use Illuminate\Database\Eloquent\Model;
use LaravelArdent\Ardent\Ardent;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Product
 * @package App
 */
class Product extends Ardent
{
    use LogsActivity;

    protected $guarded = [];

    public static $rules = array(
        'name'                  => 'required|between:3,80',
    );

    public static function boot() {
        // Initialize Container for Solr
        $larangCore = app(LarangCore::class);

        // Boot Parent Class
        parent::boot();

        // Event while Create/Update User record
        self::saved(function($product) use ($larangCore)
        {
            // Run indexer for update in solr
            $larangCore->indexer('product', $product->id);
        });
        self::deleted(function($product) use ($larangCore)
        {
            // Run indexer for update in solr
            $larangCore->deleteDocument('product-' . $product->id);
        });
    }
}
