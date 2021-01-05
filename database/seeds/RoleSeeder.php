<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::whereNotNull('id')->delete();

         //super admin
         Role::create([
            'name'=>'superAdmin',
        ]);

        //admin
        Role::create([
            'name'=>'admin',
        ]);

        //seller
        Role::create([
            'name'=>'seller',
        ]);

        //cashier
        Role::create([
            'name'=>'cashier',
        ]);
    }
}
