<?php

namespace App\Events\product\provider;

use App\Provider;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductProviderCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $providerCreated;
    public $message;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider)
    {
        $this->providerCreated = [
            'id' => $provider->id,
            'name' => $provider->name,
            'telephone1' => $provider->telephone1,
            'telephone2' => $provider->telephone2,
            'deleteRoute' => route('product.provider.delete',$provider->id),
            'updateRoute' => route('product.provider.update',$provider->id),
            'viewRoute' => route('product.provider.view',$provider->id),
            'itemLeft' => $provider->item_left,
        ];
        $this->message = __('notyf.provider.created',['name' => $provider->name]);
        $count = Provider::count();

        $this->count = trans_choice('item.provider.count',$count,['count',$count]);
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
        return 'ProductProviderCreatedEvent';
    }
}
