<?php

namespace App\Events\product\provider;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductProviderUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $providerUpdated;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider)
    {
        //format template in front end
        //pass to a js string format custom prototype
        $this->providerUpdated = [
            'id' => $provider->id,
            'name' => $provider->name,
            'telephone1' => $provider->telephone1,
            'telephone2' => $provider->telephone2,
            'deleteRoute' => route('product.provider.delete',$provider->id),
            'updateRoute' => route('product.provider.update',$provider->id),
            'viewRoute' => route('product.provider.view',$provider->id),
            'itemLeft' => $provider->item_left,
        ];
        $this->message = __('notyf.provider.updated',['name'=>$provider->name]);
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
        return 'ProductProviderUpdatedEvent';
    }
}
