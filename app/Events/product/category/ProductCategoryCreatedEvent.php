<?php

namespace App\Events\product\category;

use App\ProductType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCategoryCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $categoryCreated;
    public $message;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->categoryCreated = [
            'id' => $category->id,
            'type' => $category->type,
            'deleteRoute' => route('product.category.delete',$category->id),
            'updateRoute' => route('product.category.update',$category->id),
            'infoRoute' => route('product.category.view',$category->id),
            'productRoute' => route('product.list',$category->type),
            'mosaic' => $category->getMosaic(),
            'count' =>  $category->products()->count(),
        ];
        $this->message = __('notyf.category.created',['name' => $category->name]);
        $count = ProductType::count();

        $this->count = trans_choice('item.category.count',$count,['count',$count]);
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
        return 'ProductCategoryCreatedEvent';
    }
}
