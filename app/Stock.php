<?php

namespace App;

use App\Events\ProductStockDeletedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'product_id','provider_id','locked',
    ];

    protected $appends = [
        'item_count','item_sold','item_damaged','item_expired','item_left','item_prices',
    ];

    protected $dispatchesEvents = [
        'deleted' => ProductStockDeletedEvent::class,
    ];

    /**
     * product stock relationship.
     * @return [type]
     */
    public function product(){
        return $this->BelongsTo('App\Product');
    }

    /**
     * Stock price relationship
     * @return [type]
     */
    public function stockPrice(){
        return $this->hasOne('App\StockPrice');
    }

    /**
     * stock item relationship
     * @return [type]
     */
    public function items(){
        return $this->hasMany('App\Item');
    }


    /**
     * Update time format en/fr.
     * @param mixed $value
     *
     * @return [type]
     */
    public function getCreatedAtAttribute($value){
       return Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    /**
     * get Stock Items count
     * @return [type]
     */
    public function getItemCountAttribute(){
        // return $this->items()->count();
        return 200;
    }


    /**get item sold/payed count
     * @return [type]
     */
    public function getItemSoldAttribute(){
        // return ($this->item_sold_by_unit + $this->item_sold_by_content);
        return 20;
    }

    /**
     * get item left in the stock count
     * @return [type]
     */
    public function getItemLeftAttribute(){
        return ( $this->item_count - $this->item_sold - $this->item_damaged - $this->item_expired );
    }

    public function getItemDamagedAttribute(){
        // return $this->items()->damaged()->count();
        return 2;
    }

    public function getItemExpiredAttribute(){
        // return $this->item()->expired();
        return 1;
    }

    /**
     * get stock item prices
     * @return [type]
     */
    public function getItemPricesAttribute(){
        return $this->stockPrice()->first();
    }


    /**
     * get buying price unit
     * @return [type]
     */
    public function buyingPriceUnit(){
        $buyingPriceCont = $this->stockPrice()->first()->buying_price_unit;
        return ($buyingPriceCont) ? number_format($buyingPriceCont,2,'.',' ') . ' FCFA' : null;
    }

    /**
     * get selling price unit
     * @return [type]
     */
    public function sellingPriceUnit(){
        $sellingPriceUnit = $this->stockPrice()->first()->selling_price_uni;
        return ($sellingPriceUnit) ? number_format($sellingPriceUnit,2,'.',' ') . ' CFA' : null;
    }

}
