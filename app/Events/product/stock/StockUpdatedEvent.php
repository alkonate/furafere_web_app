<?php

namespace App\Events\product\stock;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stockUpdated;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stock)
    {
        //format template in front end
        //pass to a js string format custom prototype
        $this->stockUpdated = [
            'id' => $stock->id,
            'deleteRoute' => route('product.stock.delete',$stock->id),
            'lockRoute' => route('product.stock.lock',$stock->id),
            'updateRoute' => route('product.stock.update',$stock->id),
            'viewRoute' => route('product.stock.view',$stock->id),
            'createdAtFormated' => $stock->created_at,
            'stockBuyingPrices' => $stock->buyingPrices(),
            'stockBuyingPriceUnit' => $stock->buyingPriceUnit(),
            'stockSellingPriceUnit' => $stock->sellingPriceUnit(),
            'stockQuantity' => $stock->quantity,
        ];
        $this->message = __('notyf.stock.updated',['stock_created_at'=>$stock->created_at]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.admin');
    }

    public function broadcastAs(){
        return 'StockUpdatedEvent';
    }
}
