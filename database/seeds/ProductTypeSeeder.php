<?php

use App\productType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        productType::whereNotNull('id')->delete();

        productType::create([
            'type' => 'Antibiotique',
        ]);

        productType::create([
            'type' => 'Anti-inflamatoire',
        ]);

    }
}
