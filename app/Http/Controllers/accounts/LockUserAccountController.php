<?php

namespace App\Http\Controllers\accounts;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class LockUserAccountController extends Controller
{



    /**
     * toggle the user locking state lock/unlock
     * @param Request $request
     *
     * @return [type]
     */
    public function toggleVault(Request $request){
        $toggle = false;
        $user = User::find($request->id);
        $toggle = ($user->isLock()) ? $user->unlock() : $user->lock();

        return json_encode(['toggle'=>$toggle]);
    }
}
