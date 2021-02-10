<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\product\stock\StockCreatedEvent;
use App\Http\Controllers\Controller;
use App\Item;
use App\Jobs\checkForExpiredItems;
use App\Jobs\sendNotificationToAllAdminUser;
use App\Product;
use App\Stock;
use App\StockPrice;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddNewStockController extends Controller
{
    use ItemTrait;

    /**
     * the default minimum month before expiration
     * @var int
     */
    protected $minExpireBefore = 3;

    protected $rules = [
        'productId' => ['required','exists:products,id'],
        'barcode' => ['required','unique:stocks,barcode'],
        'providerId' => ['required','exists:providers,id'],
        'itemCount.*' => ['required','numeric','min:1'],
        'buyingPriceUnit' => ['required','numeric','min:0'],
        'sellingPriceUnit' => ['required','numeric','min:0'],
    ];


    public function __construct() {
        $date = now()->addMonths($this->minExpireBefore);
        $this->rules ['expireDate.*'] = [
            'required',
            'date',
            'after:' . $date,
        ];
    }

    /**
     * Add new stock of product.
     * @param Request $request
     *
     * @return [type]
     */
    public function addNewStock(Request $request){

        $validator = Validator::make($request->all(),$this->rules);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

        $newStock = new Stock([
            'product_id' => $request->productId,
            'provider_id'=> $request->providerId,
            'barcode' => $request->barcode,
            'locked' => false,
            ]);

        DB::transaction(function () use ($request,$newStock) {

            $newStock = Product::find($request->productId)->stocks()->save($newStock);

            foreach ($this->fusionTwoArrays($request->itemCount,$request->expireDate) as $quantity => $expired_at) {
                    $newStock->items()->save(new Item(['quantity'=>$quantity,'expired_at'=>$expired_at]));
            }

            $newStock->stockPrices()->save(new StockPrice(['buying_price_unit' => $request->buyingPriceUnit,
                                                            'selling_price_unit' => $request->sellingPriceUnit,
                                                            ]));

        });

        // distpatch new stock created event to share the event with the front-end
        StockCreatedEvent::dispatch($newStock);
        //start a new job of sending notification to all superadmin and admin
        // sendNotificationToAllAdminUser::dispatch($newStock,'App\Notifications\newStockAddedNotification');

        return response()->json(['success'=> $newStock]);

    }

    /**
 * Fusion two arrays in one array the first array values will be the keys
 * and the second array values will be the values of the new array
 * @param array itemCount
 * @param array expireDate
 *
 * @return array
 */
protected function fusionTwoArrays(array $itemCount, array $expireDate){
    $itemCount1 = [];
    $expireDate1 = [];
    $fusion = [];
    foreach ($itemCount as $value) {
        $itemCount1 [] = $value;
    }
    foreach ($expireDate as $value) {
        $expireDate1 [] = $value;
    }

    for ($i=0; $i < sizeof($itemCount); $i++) {
        $fusion [$itemCount1[$i]] = $expireDate1[$i];
    }

    return $fusion;
}
}
