<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\ProductNewStockCreatedEvent;
use App\Events\ProductStockDeletedEvent;
use App\Http\Controllers\Controller;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class deleteStockController extends Controller
{
    /**
     * delete stock from DB AJAX only
     * @param mixed $id
     *
     * @return [type]
     */
    public function deleteStock(Request $request,$stockId){

        $validator = Validator::make(['id' => $stockId,],['id' => 'exists:stocks,id']);

        if($validator->fails()){
            return response()->json([
                'validation' => false,
                'messages' => __('Invalid stock Id'),
            ]);
        }

       if(Hash::check($request->deleteStockPasswordInput,auth()->user()->password)){

            Stock::find($stockId)->delete();

            // broadcast(new ProductStockDeletedEvent($stockId));

            return response()->json([
                'success' => true,
            ]);
       }else{
           return response()->json([
               'error' => true,
               'messages' => ['deleteStockPasswordInput' => __('Invalid password.')],
           ]);
       }

    }
}
