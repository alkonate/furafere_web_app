<?php

namespace App\Events\product\category;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCategoryUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $categoryUpdated;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        //format template in front end
        //pass to a js string format custom prototype
        $this->categoryUpdated = [
            'id' => $category->id,
            'type' => $category->type,
            'deleteRoute' => route('product.category.delete',$category->id),
            'updateRoute' => route('product.category.update',$category->id),
            'infoRoute' => route('product.category.view',$category->id),
            'productRoute' => route('product.list',$category->type),
            'mosaic' => $category->getMosaic(),
            'count' =>  $category->products()->count(),
        ];
        $this->message = __('notyf.category.updated',['name'=>$category->name]);
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
        return 'ProductCategoryUpdatedEvent';
    }
}
