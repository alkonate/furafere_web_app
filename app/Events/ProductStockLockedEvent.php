<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductStockLockedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stockLocked;
    public $locked;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stock)
    {
        $this->stockLocked = route('product.stock.lock',$stock->id);
        $this->locked = $stock->locked;
        if($this->locked){
            $this->message = __('notyf.stock.locked',['stock_created_at' => $stock->created_at]);
        }else{
            $this->message = __('notyf.stock.unlocked',['stock_created_at' => $stock->created_at]);
        }
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
}
