<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'stock_id','quantity', 'expired_at','expired','out_of_stock'
    ];

    protected $appends = [
        'left','left_salable','orders_waiting','orders_canceled','orders_sold',
        'orders_not_sold','damaged','expired_count'
    ];

    /**
     * Item stock relationship
     * @return [type]
     */
    public function stock(){
        return $this->belongsTo('App\Stock');
    }

     /**
     * Damage-item relationship
     * @return [type]
     */
    public function damage(){
        return $this->hasMany('App\Damage');
    }

    /**
     * expire date mutator to a date format
     * @param mixed $value
     *
     * @return [type]
     */
    public function setExpiredAtAttribute($value){
        $this->attributes['expired_at'] = Carbon::parse($value);
    }

    /**
     * determine if items have got expired.
     * @return boolean
     */
    public function hasExpired(){
        if(Carbon::parse($this->expired_at)->lessThanOrEqualTo(now()->createMidnightDate())){
            $expired = true;
        }else{
            $expired = false;
        }
        return $expired;
    }


    /**
     * item left present in the stock not sold yet.
     * @return integer
     */
    public function getLeftAttribute(){
        $itemAcc = 0;
        $itemAcc += $this->quantity - $this->damaged - $this->ordersSold;
        return $itemAcc;
    }

    /**
     * item left not including ordered item wating for payment that can be sold.
     * @return integer
     */
    public function getLeftSalableAttribute(){
        $itemAcc = 0;
        $itemAcc += $this->quantity - $this->damaged - $this->orderedSold - $this->orderedWaiting;
        return $itemAcc;
    }


    /**
     * item ordered in waiting state.
     * @return integer
     */
    public function getOrdersWaitingAttribute(){
        $itemAcc = 0;
        // foreach ($this->orders()->whereIn('status',['waiting',null])->pivot->item_quantity as $itemQuantity) {
        //    $itemAcc += $itemQuantity;
        // }
        return $itemAcc;
    }
/**
     * item ordered in canceled.
     * @return integer
     */
    public function getOrdersCanceledAttribute(){
        $itemAcc = 0;
        // foreach ($this->orders()->where('status','cancel')->pivot->item_quantity as $itemQuantity) {
        //    $itemAcc += $itemQuantity;
        // }
        return $itemAcc;
    }
    /**
     * item ordered and sold.
     * @return integer
     */
    public function getOrdersSoldAttribute(){
        $itemAcc = 0;
        // foreach ($this->orders()->where('status','validate')->pivot->item_quantity as $itemQuantity) {
        //    $itemAcc += $itemQuantity;
        // }
        return $itemAcc;
    }

    /**
     * Item orders not validate yet state not sold yet.
     * @return integer
     */
    public function getOrdersNotSoldAttribute(){
        $itemAcc = 0;
        // foreach ($this->orders()->whereNot('status','validate')->pivot->item_quantity as $itemQuantity) {
        //    $itemAcc += $itemQuantity;
        // }
        return $itemAcc;
    }

    /**
     * item damaged
     * @return [type]
     */
    public function getDamagedAttribute(){
        $itemAcc = 0;
        // foreach ($this->damage as $damagedItem) {
        //    $itemAcc += $damagedItem->quantity;
        // }
        return $itemAcc;
    }

    /**
     * item expired count.
     * @return [type]
     */
    public function getExpiredCountAttribute(){
        $itemAcc = 0;
        if($this->hasExpired()){
            $itemAcc = $this->left;
        }
        return $itemAcc;
    }

}
