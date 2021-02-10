<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\product\stock\StockLockedEvent;
use App\Http\Controllers\Controller;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LockStockController extends Controller
{
    public function lockStock($stockId){

        $validator = Validator::make(['id' => $stockId,],['id' => 'exists:stocks,id']);

        if($validator->fails()){
            return response()->json([
                'validation' => false,
                'messages' => __('Invalid stock Id'),
            ]);
        }
        $stock = Stock::find($stockId);
        if($stock->locked){
           $stock->locked = false;
        }else{
            $stock->locked = true;
        }

        if($stock->save()){

            //broadcast stock locked/unlocked event
            broadcast(new StockLockedEvent($stock));

            return response()->json([
                'error' => false,
                'locked' => $stock->locked,
            ]);
        }


    }
}
