<?php

namespace App\Traits;

use App\Role;

trait TransRolesTrait
{

    /**
     * Translate user roles into the appropriate local language
     * @return [type]
     */
    public function transRolesName(){

        $roles = Role::where('name','!=','superAdmin')->get();
        $roleDefault = new \stdClass();
        $roleDefault->name = 'Role';

        $rolesTrans = [$roleDefault];

        foreach ($roles as  $role) {

            $roleTrans = new \stdClass();

            if($role->name == trans('role.admin',[],'en')){
                $roleTrans->name = trans('role.admin');
             }
             elseif($role->name == trans('role.seller',[],'en')){
                $roleTrans->name = trans('role.seller');
            }
             elseif($role->name == trans('role.cashier',[],'en')){
                $roleTrans->name = trans('role.cashier');
             }

             $rolesTrans [] = $roleTrans;
        }
        return $rolesTrans;
    }

}
