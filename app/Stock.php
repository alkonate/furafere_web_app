<?php

namespace App;

use App\Events\product\stock\StockDeletedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'product_id','provider_id','locked','barcode',
    ];

    protected $appends = [
        'quantity','prices','left','left_salable','orders_waiting',
        'orders_canceled','orders_sold','orders_not_sold','damaged',
        'expired_count'
    ];

    protected $dispatchesEvents = [
        'deleted' => StockDeletedEvent::class,
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
    public function stockPrices(){
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
       return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * get Stock Items count
     * @return [type]
     */
    public function getQuantityAttribute(){
        $quantity = 0;
        foreach ($this->items as $item) {
            $quantity += $item->quantity;
        }
        return $quantity;
    }



    /**
     * get stock item prices
     * @return [type]
     */
    public function getPricesAttribute(){
        return $this->stockPrices()->first();
    }

    /**
     * get buying price for the entier stock
     * @return [type]
     */
    public function buyingPrices(){
        $buyingPrice = ($this->prices->buying_price_unit * $this->quantity);
        return ($buyingPrice) ? number_format($buyingPrice,2,'.',' ') . ' FCFA' : null;
    }

    /**
     * get buying price unit
     * @return [type]
     */
    public function buyingPriceUnit(){
        $buyingPriceUnit = $this->stockPrices()->first()->buying_price_unit;
        return ($buyingPriceUnit) ? number_format($buyingPriceUnit,2,'.',' ') . ' FCFA' : null;
    }

    /**
     * get selling price unit
     * @return [type]
     */
    public function sellingPriceUnit(){
        $sellingPriceUnit = $this->stockPrices()->first()->selling_price_unit;
        return ($sellingPriceUnit) ? number_format($sellingPriceUnit,2,'.',' ') . ' FCFA' : null;
    }


    /**
     * determine if items have got expired.
     * @return boolean
     */
    public function hasExpired(){

        foreach ($this->items as $item) {
            if(!$item->hasExpired()){
                return false;
                die();
            }
        }
        return true;
    }

    /**
     * determine if items have got out of stock.
     * @return boolean
     */
    public function getOutOfStockAttribute(){

        foreach ($this->items as $item) {
            if(!$item->out_of_stock){
                return false;
                die();
            }
        }
        return true;
    }

    /**
     * item left present in the stock not sold yet.
     * @return integer
     */
    public function getLeftAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->left;
        }
        return $itemAcc;
    }

    /**
     * item left not including ordered item wating for payment that can be sold.
     * @return integer
     */
    public function getLeftSalableAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->left_salable;
        }
        return $itemAcc;
    }


    /**
     * item ordered in waiting state.
     * @return integer
     */
    public function getOrdersWaitingAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->orders_waiting;
        }
        return $itemAcc;
    }
/**
     * item ordered in canceled.
     * @return integer
     */
    public function getOrdersCanceledAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->orders_canceled;
        }
        return $itemAcc;
    }
    /**
     * item ordered and sold.
     * @return integer
     */
    public function getOrdersSoldAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->orders_sold;
        }
        return $itemAcc;
    }

    /**
     * Item orders not validate yet state not sold yet.
     * @return integer
     */
    public function getOrdersNotSoldAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->orders_not_sold;
        }
        return $itemAcc;
    }

    /**
     * item damaged
     * @return [type]
     */
    public function getDamagedAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->damaged;
        }
        return $itemAcc;
    }

    /**
     * item expired count.
     * @return [type]
     */
    public function getExpiredCountAttribute(){
        $itemAcc = 0;
        foreach ($this->items as $item) {
            $itemAcc += $item->expired_count;
        }
        return $itemAcc;
    }

}
