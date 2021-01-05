<?php

namespace App;

use App\Events\product\category\ProductCategoryCreatedEvent;
use App\Events\product\category\ProductCategoryDeletedEvent;
use App\Events\product\category\ProductCategoryUpdatedEvent;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
        'type',
    ];

    protected $dispatchesEvents = [
        'created' => ProductCategoryCreatedEvent::class,
        'deleted' => ProductCategoryDeletedEvent::class,
        'updated' => ProductCategoryUpdatedEvent::class,
    ];

    public $defaultMosaic = '/img/mosaic-unknown.jpeg';

    public function products(){
        return $this->hasMany('App\Product','type_id');
    }

    public function getMosaic(){
        return $this->mosaic ? '/' . $this->mosaic : $this->defaultMosaic;
    }
}
