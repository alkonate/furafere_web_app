<?php

namespace App\Http\Controllers\accounts;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordUserAccountController extends Controller
{
    public function reset(Request $request){
        if($user = User::find($request->id)){
            $isReset = false;

            $useRoleName = $user->roles->first()->name;

            $user->updateModel([
                'password' => Hash::make($useRoleName),
                'password_updated' => FALSE,
            ]);

            return json_encode([
                'isReset' => $user->save(),
                'newPassword' => $useRoleName,
                ]);
        }
    }
}
