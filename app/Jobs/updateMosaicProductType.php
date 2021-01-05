<?php

namespace App\Jobs;
use App\Product;
use App\ProductType;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class updateMosaicProductType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $positions = [
        'top-left',
        'top',
        'top-right',
        'left',
        'center',
        'right',
        'bottom-left',
        'bottom',
        'bottom-right',
    ];
    private $mosaicMAX = 9;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            \shuffle($this->positions);
            $productTypes= ProductType::all();
            foreach ($productTypes as $productType) {

                if(!$productType->mosaic || now()->diffInDays($productType->updated_at) > 10 || 1){

                    $products = $productType->products()->orderBy('updated_at','desc')->limit(9)->get();

                    $canvas = Image::canvas(200,200);

                    for($current=0; $current < 9 ; $current++) {

                            foreach ($products as $product) {
                                $canvas->insert(\public_path($product->getthumbnail(true)),$this->positions[$current]);
                                $current++;
                            }

                            if($current == 9) break;
                            $canvas->insert(\public_path('img/minify-unknown.jpeg'),$this->positions[$current]);
                    }


                    //delete old mosaic
                    if(file_exists(public_path($productType->mosaic))  && $productType->mosaic ){
                        unlink(public_path($productType->mosaic));
                    }

                    //save and update the product type mosaic
                    $path = 'mosaic/' . $productType->type . '-' . time() . '.jpeg';
                    $canvas->save(\public_path($path));
                    $productType->mosaic = $path;
                    $productType->save();

                }
            }
    }
}
