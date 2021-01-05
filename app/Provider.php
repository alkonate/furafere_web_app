<?php

namespace App;

use App\Events\product\provider\ProductProviderCreatedEvent;
use App\Events\product\provider\ProductProviderDeletedEvent;
use App\Events\product\provider\ProductProviderUpdatedEvent;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name','address','telephone1','telephone2','email',
    ];

    protected $dispatchesEvents = [
        'created' => ProductProviderCreatedEvent::class,
        'deleted' => ProductProviderDeletedEvent::class,
        'updated' => ProductProviderUpdatedEvent::class,
    ];

    protected $appends = [
        'item_left',
    ];

    /**
     * provider stock relationship
     * @return [type]
     */
    public function stocks(){
        return $this->hasMany('App\Stock');
    }

    public function getItemLeftAttribute(){
        //provider item left in the stock not sell yet.
        return 1000;
    }

}
