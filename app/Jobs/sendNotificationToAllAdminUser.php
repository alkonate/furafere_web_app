<?php

namespace App\Jobs;

use App\User;
use App\Role;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendNotificationToAllAdminUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $notificationType;

    /**
     * @param string $model
     * @param string $notificationType
     * @param array $notificationArg
     */
    public function __construct($model,$notificationType,$notificationArg=[])
    {
        $this->notificationType = new $notificationType ($model,$notificationArg);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Role::where('name','superadmin')->first()->users()->first()->notify($this->notificationType);

        foreach (Role::where('name','admin')->first()->users as $user){
            $user->notify($this->notificationType);
        }
    }
}
