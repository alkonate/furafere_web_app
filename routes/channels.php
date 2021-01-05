<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
//user personal channel
Broadcast::channel('App.User.{id}', function ($user, $id) {
    
    return ( (int) $user->id == (int)$id )
    ? true
    : false;
});

//users roles channel (superadmin,admin,seller,cashier)
Broadcast::channel('App.User.{role}',function($user,$role){
   
    return (($user->hasrole($role) || $user->isSuperAdmin()))
    ? true
    : false;
});
