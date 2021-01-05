<?php

namespace App\Http\Controllers\accounts;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DeleteUserAccountController extends Controller
{
    /**
     * delete user account
     * @param Request $request
     *
     * @return [type]
     */
    public function delete(Request $request){
        $user = User::find($request->id);

        return json_encode(['delete'=>$user->delete()]);

    }
}
