<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'stock_id','quantity', 'barcode', 'expired_at',
    ];

    /**
     * Item stock relationship
     * @return [type]
     */
    public function stock(){
        return $this->belongsTo('App\Stock');
    }
}
