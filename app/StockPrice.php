<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockPrice extends Model
{
    protected $fillable = [
        'stock_id','buying_price_unit','selling_price_unit'
    ];

    protected $hidden = [
        'id','created_at','updated_at','stock_id',
    ];

    /**
     * price stock relationship.
     * @return [type]
     */
    public function stock(){
        return $this->belongsTo('App\Stock');
    }
}
