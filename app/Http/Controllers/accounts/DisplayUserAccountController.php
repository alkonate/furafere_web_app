<?php

namespace App\Http\Controllers\accounts;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DisplayUserAccountController extends Controller
{

    public function showAccount(User $user){

        $userInfo = $user->info;
        $userRole = trans($user->roles->first()->name);
        $userImage = $user->getImage();

        return view('user.user',[
            'user'=>$user,
            'userInfo'=>$userInfo,
            'userImage'=>$userImage,
            'userRole'=>$userRole,
        ]);

    }

    public function showProfil(User $user){

        $userInfo = $user->info;
        $userRole = trans($user->roles->first()->name);
        $userImage = $user->getImage();

        return view('user.profil',[
            'user'=>$user,
            'userInfo'=>$userInfo,
            'userImage'=>$userImage,
            'userRole'=>$userRole,
        ]);

    }

}
