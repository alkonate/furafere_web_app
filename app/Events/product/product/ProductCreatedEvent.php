<?php

namespace App\Events\product\product;

use App\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCreatedEvent implements shouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productCreated;
    public $message;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->productCreated = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->miniDescription(),
            'thumbnail' => $product->getthumbnail(),
            'deleteRoute' => route('product.delete',$product->id),
            'updateRoute' => route('product.update',$product->id),
            'viewRoute' => route('product.view',$product->id),
            'stock' => $product->stocks()->count(),
        ];
        $this->message = __('notyf.product.created',['name' => $product->name]);
        $count = Product::where('type_id',$product->type_id)->count();

        $this->count = trans_choice('item.product.count',$count,['count',$count]);
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
        return 'ProductCreatedEvent';
    }
}
