<?php

namespace App\Notifications;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newProductAddedNotification extends Notification implements ShouldBroadcast,ShouldQueue
{
    use Queueable;

    private $newProduct;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $newProduct)
    {
        $this->newProduct = $newProduct;
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
     * Specify the type/name of the notification
     * @return [type]
     */
    public function broadcastType(){
        return 'newProductAddedNotification';
    }

    /**
     * save new product notification into the db.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toDatabase($notifiable){

        return [
            'product_id' => $this->newProduct->id,
            'product_name' => $this->newProduct->name,
            'product_thumbnail' => $this->newProduct->getThumbnail(true),
        ];
    }

    /**
     * prevent client side code for new product created.
     * @param mixed $notifiable
     *
     * @return [type]
     */
    public function toBroadcast($notifiable){

        return new BroadcastMessage ([
            'message' => __("New product created"),
            'product_id' => $this->newProduct->id,
            'product_name' => $this->newProduct->name,
            'product_thumbnail' => $this->newProduct->getThumbnail(true),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
       //
    }
}
