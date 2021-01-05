<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Info;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::whereNotNull('id')->delete();

        $superAdminRole =  Role::where('name','superAdmin')->first();
        $adminRole =  Role::where('name','admin')->first();
        $sellerRole =  Role::where('name','seller')->first();
        $cashierRole =  Role::where('name','cashier')->first();

        //super admin
        $superAdmin = User::create([
            'username'=>'superAdmin',
            'password'=>bcrypt('superAdmin'),
        ]);

        //admin1
        $admin1 = User::create([
            'username'=>'admin1',
            'password'=>bcrypt('admin'),
        ]);
        //admin2
        $admin2 = User::create([
            'username'=>'admin2',
            'password'=>bcrypt('admin'),
        ]);

        //seller1
        $seller1 = User::create([
            'username'=>'seller1',
            'password'=>bcrypt('seller'),
        ]);
        //seller2
        $seller2 = User::create([
            'username'=>'seller2',
            'password'=>bcrypt('seller'),
        ]);

        //cashier1
        $cashier1 = User::create([
            'username'=>'cashier1',
            'password'=>bcrypt('cashier'),
        ]);
        //cashier2
        $cashier2 = User::create([
            'username'=>'cashier2',
            'password'=>bcrypt('cashier'),
        ]);

        //super admin
        $superAdmin->info()->create([
            'firstname'=>'superAdmin',
            'lastname'=>'superAdmin',
            'email'=>'superAdmin@superAdmin.com',
            'telephone'=>'0000000000',
            'address'=>'pharmancy',
        ]);

        //admin1
       $admin1->info()->create([
           'firstname'=>'admin1',
           'lastname'=>'admin1',
           'email'=>'admin1@admin1.com',
           'telephone'=>'0000000000',
           'address'=>'pharmancy',
       ]);
        //admin2
        $admin2->info()->create([
            'firstname'=>'admin2',
            'lastname'=>'admin2',
            'email'=>'admin2@admin2.com',
            'telephone'=>'0000000000',
            'address'=>'pharmancy',
        ]);

       //seller1
       $seller1->info()->create([
        'firstname'=>'seller1',
        'lastname'=>'seller1',
        'email'=>'seller1@seller1.com',
        'telephone'=>'0000000000',
        'address'=>'pharmancy',
        ]);
         //seller2
       $seller2->info()->create([
        'firstname'=>'seller2',
        'lastname'=>'seller2',
        'email'=>'seller2@seller2.com',
        'telephone'=>'0000000000',
        'address'=>'pharmancy',
        ]);

        //cashier1
        $cashier1->info()->create([
            'firstname'=>'cashier1',
            'lastname'=>'cashier1',
            'email'=>'cashier1@cashier1.com',
            'telephone'=>'0000000000',
            'address'=>'pharmancy',
        ]);
        //cashier2
        $cashier2->info()->create([
            'firstname'=>'cashier2',
            'lastname'=>'cashier2',
            'email'=>'cashier2@cashier2.com',
            'telephone'=>'0000000000',
            'address'=>'pharmancy',
        ]);

        $superAdmin->roles()->attach($superAdminRole);
        $admin1->roles()->attach($adminRole);
        $admin2->roles()->attach($adminRole);
        $seller1->roles()->attach($sellerRole);
        $seller2->roles()->attach($sellerRole);
        $cashier1->roles()->attach($cashierRole);
        $cashier2->roles()->attach($cashierRole);
    }
}
