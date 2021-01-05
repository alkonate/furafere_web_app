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

class ProductCategoryDeletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $categoryDeleted;
    public $message;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->categoryDeleted = route('product.category.delete',$category->id);
        $this->message = __('notyf.category.deleted',['name'=>$category->type]);
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
        return 'ProductCategoryDeletedEvent';
    }
}
