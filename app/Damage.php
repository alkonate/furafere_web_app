<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $fillable = [
        'item_id','quantity','description'
    ];

    /**
     * Damage-item relationship
     * @return [type]
     */
    public function item(){
        return $this->belongsTo('App\Item');
    }
}
