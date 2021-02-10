<?php

namespace App\Notifications;

use App\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class newStockAddedNotification extends Notification
{
    use Queueable;
    protected $newStock;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Stock $newStock)
    {
        $this->newStock = $newStock;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * specify the name/type of notification
     * @return [type]
     */
    public function broadcastType(){
        return 'newStockAddedNotification';
    }

   /**
     * save new stock notification into the db.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toDatabase($notifiable){

        return [
            'stock_id' => $this->newStock->id,
            'item_count' => $this->newStock->itemCount,
            'product_name' => $this->newStock->product->name,
            'product_thumbnail' => $this->newStock->product->getThumbnail(true),
        ];
    }

    /**
     * prevent client side code for new stock created.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toBroadcast($notifiable){

        return new BroadcastMessage ([
            'message' => __("New stock created"),
            'stock_id' => $this->newStock->id,
            'quantity' => $this->newStock->quantity,
            'product_name' => $this->newStock->product->name,
            'product_thumbnail' => $this->newStock->product->getThumbnail(true),
        ]);
    }

}
