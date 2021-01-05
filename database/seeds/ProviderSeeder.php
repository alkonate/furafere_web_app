<?php

use App\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::whereNotNull('id')->delete();

        Provider::create([
            'name' => 'Telepharm',
            'address' => 'Senegal DKR PIKINE',
            'email' => 'telepharm@gmail.com',
            'telephone1' => '33 434 33 33',
            'telephone2' => '77 334 23 11',
        ]);

        Provider::create([
            'name' => 'Cobpharmacy',
            'address' => 'Senegal THIES SOFRACO',
            'email' => 'Cobpharmacy@gmail.com',
            'telephone1' => '33 434 33 33',
            'telephone2' => '77 334 23 11',
        ]);

        Provider::create([
            'name' => 'Tekpharma',
            'address' => 'Senegal SAINT LIOUS',
            'email' => 'Tekpharma@gmail.com',
            'telephone1' => '33 434 33 33',
            'telephone2' => '77 334 23 11',
        ]);
    }
}
