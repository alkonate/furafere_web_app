<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\ProductNewStockCreatedEvent;
use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;
use App\StockPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddNewStockController extends Controller
{

    protected $nullablePriceRule =  ['nullable'];
    protected $NotNullablePriceRule =   ['regex:/^[0-9]+(\.[0-9]+)?$/'];

    /**
     * Add new stock of product.
     * @param Request $request
     *
     * @return [type]
     */
    public function addNewStock(Request $request){

        $validator = Validator::make($request->all(),[
            'productName' => ['string','exists:stocks,name'],
            'sellingMethod' => ['string',Rule::in(['unit','content','both'])],
            'buyingPriceUnit' => ['regex:/^[0-9]+(\.[0-9]+)?$/'],
            'sellingPriceUnit' => ($request->sellingMethod == 'unit' || $request->sellingMethod == 'both') ? $this->NotNullablePriceRule : $this->nullablePriceRule,
            'sellingPriceContent' => ($request->sellingMethod == 'content' || $request->sellingMethod == 'both') ? $this->NotNullablePriceRule : $this->nullablePriceRule,
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => true,
                'messages' => $validator->errors(),
                ]);
        }

       $product = Product::where('name',$request->ProductName)->first();
       $stock =  $product->stocks()->save(new Stock());

       if($request->sellingMethod == 'unit'){
           $stock->stockPrice()->create([
            'buying_price' => $request->buyingPriceUnit,
            'selling_price_uni' => $request->sellingPriceUnit,
           ]);

       }else if($request->sellingMethod == 'content'){
        $stock->stockPrice()->create([
            'buying_price' => $request->buyingPriceUnit,
            'selling_price_cont' => $request->sellingPriceContent,
           ]);
       }else{
        $stock->stockPrice()->create([
            'buying_price' => $request->buyingPriceUnit,
            'selling_price_uni' => $request->sellingPriceUnit,
            'selling_price_cont' => $request->sellingPriceContent,
           ]);
       }
       $stock->refresh();

    broadcast(new ProductNewStockCreatedEvent($stock));

    return response()->json(['success'=> true]);

    }


}
