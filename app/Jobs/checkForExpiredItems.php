<?php

namespace App\Jobs;

use App\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * [Description checkForExpiredItems]
 * this job is executed to find out expired items inside stocks
 */
class checkForExpiredItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // item use when checking a single stock not the entire inventory
    protected $item;
    // boolean set to check if the entire INVENTORY need to be checked or a set of item
    protected $check_for_entire_inventory;
    // minimun month before the stock expire
    protected $min_day_before_expiration = 200;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Item $item=null,$check_for_entire_inventory=true)
    {
        $this->item = $item;
        $this->check_for_entire_inventory = $check_for_entire_inventory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if($this->check_for_entire_inventory){
            $this->checkForExpiredItemsInEntireInventory();
        }else{
            // checking for single stock of items
            $this->checkForExpiredItemsInAStock($this->item);
        }
    }

    /**
     * look in the entire inventory of product for expired product.
     * @return [type]
     */
    protected function checkForExpiredItemsInEntireInventory(){

       Item::where(function($query){
            $query->whereNull('expired')->orWhere('expired',false);
       })->where(function($query){
        $query->whereNull('out_of_stock')->orWhere('out_of_stock',false);
       })->orderBy('id')
            ->chunk(20,function($items){

                    foreach ($items as $item) {
                        $this->checkForExpiredItemsInAStock($item);
                    }

            });
    }


    /**
     * Check if items expired or will expire soon (1month) and send notification.
     * @param Item $item
     *
     * @return [type]
     */
    protected function checkForExpiredItemsInAStock(Item $item){
        $daysBeforeOrAfterExpiration = Carbon::parse($item->expired_at)->diffInDays(now()->createMidnightDate());

        if($item->hasExpired()){
            // start the job to send notification item expired
            sendNotificationToAllAdminUser::dispatch($item,'App\Notifications\itemExpiredNotification',[$daysBeforeOrAfterExpiration]);
             // mark the items expired
            // $item->update(['expired' => true]);
        }else{

            if($daysBeforeOrAfterExpiration <= $this->min_day_before_expiration){
                // start the job to send notification item expired in x days left
                sendNotificationToAllAdminUser::dispatch($item,'App\Notifications\itemAlmostExpiredNotification',[$daysBeforeOrAfterExpiration]);
            }

        }
    }
}
