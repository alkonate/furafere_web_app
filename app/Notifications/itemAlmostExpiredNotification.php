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

class itemAlmostExpiredNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $itemAlmostExpired;
    public $daysBeforeExpiration;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Item $item,$notificationArg)
    {
        $this->itemAlmostExpired = $item;
        $this->daysBeforeExpiration = $notificationArg[0];
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
        return 'itemAlmostExpiredNotification';
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
        $product = $this->itemAlmostExpired->stock->product;
        $stockItemLeft = $this->itemAlmostExpired->stock->left;
        $itemLeft = $this->itemAlmostExpired->left;
        $broadcastMessage = [
            'message' => __("item.stock.AlmostExpired",
                                ['itemLeft'=>$itemLeft,
                                'stockItemLeft'=>$stockItemLeft,
                                'expiredDate'=>Carbon::parse($this->itemAlmostExpired->expired_at)->format('d-m-Y'),
                                'daysBeforeExpiration'=>$this->daysBeforeExpiration,
                                ]),
            // 'productName' => $this->newProduct->id,
            'product_name' => $product->name,
            'product_thumbnail' => $product->getThumbnail(true),
        ];

        return new BroadcastMessage ($broadcastMessage);
    }
}
