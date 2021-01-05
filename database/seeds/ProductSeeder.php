<?php

use App\Product;
use App\productType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::whereNotNull('id')->delete();

        // product 1
        $product1['name'] = 'Amauxiline';
        $product1['type_id'] = productType::where('type','Antibiotique')->first()->id;
        $product1['Description'] = "Contre les bactteries les infections...";
        $product1['min_quantity'] = 10;

        product::create([
            'name' => $product1['name'],
            'type_id' => $product1['type_id'],
            'description' => $product1['Description'],
            'min_quantity' => $product1['min_quantity'],
        ]);

        //product 2
        $product2['type_id'] = productType::where('type','Anti-inflamatoire')->first()->id;
        $product2['Description'] = "Anti-inflimation contre les infections...";
        $product2['min_quantity'] = 10;
        $product2['name'] = 'Protexine';

        product::create([
            'name' => $product2['name'],
            'type_id' => $product2['type_id'],
            'description' => $product2['Description'],
            'min_quantity' => $product2['min_quantity'],
        ]);

    }
}
