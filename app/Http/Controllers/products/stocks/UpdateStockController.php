<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\product\stock\StockUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Item;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateStockController extends Controller
{

    protected $rules = [
        'stock.providerId' => ['required','exists:providers,id'],
        'stock.buyingPriceUnit' => ['required','numeric','min:0'],
        'stock.sellingPriceUnit' => ['required','numeric','min:0'],

        'stock.items.original.id.*' => ['required','exists:items,id'],

        'stock.items.update.id.*' => ['nullable'],
        'stock.items.update.count.*' => ['required','numeric','min:1'],
        'stock.items.update.expireDate.*' => ['required','date'],
    ];

    /**
     * update a stock and related data (item,stockPrices..)
     * @param Request $request
     * @param mixed $stockId
     *
     * @return [type]
     */
    public function updateStock(Request $request,$stockId){

        $validator = Validator::make($request->all(),$this->rules);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

        $stock = Stock::where('id',$stockId)->first();
        if($stock){

            if($stock->barcode != $request->stock['barcode'] && Stock::where('barcode',$request->stock['barcode'])->exists()){

                $messages = [
                    'barcode' => __('validation.unique',['attribute'=>'barcode']),
                ];

                return response()->json([
                    'invalid' => true,
                    'messages' => $messages,
                    ]);
            }

            DB::transaction(function () use ($request,$stock) {
                // update stock items
                foreach ($this->fusionThreeArray($request->stock['items']['update']['id'],$request->stock['items']['update']['count'],$request->stock['items']['update']['expireDate']) as $id => $countExpireDate) {
                    if(Item::where('id',$id)->exists()){
                        Item::find($id)->update([
                            'quantity' => key($countExpireDate),
                            'expired_at' =>  $countExpireDate[key($countExpireDate)]
                        ]);

                    }else{
                        $stock->items()->save( new Item([
                            'quantity' => key($countExpireDate),
                            'expired_at' =>  $countExpireDate[key($countExpireDate)]
                        ]));
                    }

                    // update stock prices
                    $stock->stockPrices()->update([
                        'buying_price_unit' => $request->stock['buyingPriceUnit'],
                        'selling_price_unit' => $request->stock['sellingPriceUnit'],
                    ]);

                    // update stock barcode and provider
                    $stock->update([
                    'provider_id' => $request->stock['providerId'],
                    'barcode' => $request->stock['barcode'],
                    ]);
                }

            });


            StockUpdatedEvent::dispatch($stock);

            return response()->json([
                'success' => true,
            ]);


            }


    }

    /**
     * Fusion Three associative to a associative array.
     * @param array $ids
     * @param array $counts
     * @param array $expireDates
     *
     * @return [type]
     */
    protected function fusionThreeArray($ids,$counts,$expireDates){
           $arr1 = [];
           $arr2 = [];
           $arr3 = [];
           $i = 0;
           foreach ($counts as $count) {
              $arr2 [] = $count;
           }
           foreach ($expireDates as $expireDate) {
            $arr3 [] = $expireDate;
            }
            foreach ($ids as $updateId) {
                if($updateId){
                    $arr1 [$updateId] = [
                        $arr2[$i] => $arr3[$i]
                    ];
                }else{
                    $arr1 ['id'.$i] = [
                        $arr2[$i] => $arr3[$i]
                    ];
                }
                $i++;
            }

            return $arr1;
    }
}
