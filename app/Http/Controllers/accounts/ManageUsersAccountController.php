<?php

namespace App\Http\Controllers\accounts;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageUsersAccountController extends Controller
{

    //number of record per page
    protected $per_page = 10;

   public function showUsers(){

        $adminInfos= DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                                    ->join('roles','roles.id','=','role_user.role_id')
                                    ->join('infos','users.id','=','infos.user_id')->where('name','admin')
                                    ->select(['users.id','firstname','lastname','username','locked'])->paginate($this->per_page);

        $sellerInfos= DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                                    ->join('roles','roles.id','=','role_user.role_id')
                                    ->join('infos','users.id','=','infos.user_id')->where('name','seller')
                                    ->select(['users.id','firstname','lastname','username','locked'])->paginate($this->per_page);

        $cashierInfos= DB::table('users')->join('role_user','users.id','=','role_user.user_id')
                                    ->join('roles','roles.id','=','role_user.role_id')
                                    ->join('infos','users.id','=','infos.user_id')->where('name','cashier')
                                    ->select(['users.id','firstname','lastname','username','locked'])->paginate($this->per_page);


     return view('user.users')->with(['adminInfos'=>$adminInfos,'sellerInfos'=>$sellerInfos,'cashierInfos'=>$cashierInfos]);
   }
}
