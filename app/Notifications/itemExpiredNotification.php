<?php

namespace App\Notifications;

use App\Item;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class itemExpiredNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $itemExpired;
    protected $daysAfterExpiration;


    /**
     * @param Item $itemExpired
     * @param array $notificationArg=[]
     */
    public function __construct(Item $itemExpired,$notificationArg=[])
    {
        $this->itemExpired = $itemExpired;
        $this->daysAfterExpiration = $notificationArg[0];
    }

   /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Specify the type/name of the notification
     * @return [type]
     */
    public function broadcastType(){
        return 'itemExpiredNotification';
    }

    /**
     * save new product notification into the db.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toDatabase($notifiable){

        return [

        ];
    }

    /**
     * prevent client side code for new product created.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toBroadcast($notifiable){
        $product = $this->itemExpired->stock->product;
        $stockItemLeft = $this->itemExpired->stock->left;
        $itemExpired = $this->itemExpired->expiredCount;
        $broadcastMessage = [
            'message' => __("item.stock.expired",[
                'itemExpired'=>$itemExpired,
                'stockItemLeft'=>$stockItemLeft,
                'expiredDate'=>Carbon::parse($this->itemExpired->expired_at)->format('d-m-Y'),
                "daysAfterExpiration"=>$this->daysAfterExpiration
                ]),
            'product_name' => $product->name,
            'product_thumbnail' => $product->getThumbnail(true),
        ];

        return new BroadcastMessage ($broadcastMessage);
    }

}
