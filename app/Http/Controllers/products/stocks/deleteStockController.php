<?php

namespace App\Http\Controllers\products\stocks;

use App\Events\product\stock\StockUpdatedEvent;
use App\Events\ProductNewStockCreatedEvent;
use App\Events\ProductStockDeletedEvent;
use App\Http\Controllers\Controller;
use App\Item;
use App\Stock;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class deleteStockController extends Controller
{

    use ItemTrait;

    /**
     * delete stock from DB AJAX only
     * @param mixed $id
     *
     * @return [type]
     */

    public function deleteMultipleStock(Request $request){

        return $this->deleteMultipleItem('stock',$request);

    }

    /**
     * Delete stock item from DB AJax only
     * @param Request $request
     *
     * @return [type]
     */
    public function deleteItem(Request $request){

        // return Item::find($request->id[0])->stock;
        $stock = Stock::whereHas('items',function($q) use ($request){
            $q->where('id',$request->id[0]);
        })->first();

        $result = $this->deleteMultipleItem('item',$request);
        if(array_key_exists('success',$result) && $result['success']){
            StockUpdatedEvent::dispatch($stock);
        }
        return response()->json($result);
    }
}
