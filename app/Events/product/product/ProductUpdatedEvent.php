<?php

namespace App\Events\product\product;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productUpdated;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        //format template in front end
        //pass to a js string format custom prototype
        $this->productUpdated = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->miniDescription(),
            'thumbnail' => $product->getthumbnail(),
            'deleteRoute' => route('product.delete',$product->id),
            'updateRoute' => route('product.update',$product->id),
            'viewRoute' => route('product.view',$product->id),
            'stock' => $product->stocks()->count(),
        ];
        $this->message = __('notyf.product.updated',['name'=>$product->name]);
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
        return 'ProductUpdatedEvent';
    }
}
