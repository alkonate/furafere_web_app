<?php

namespace App\Http\Controllers\products\stocks;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageStocksController extends Controller
{

    protected $per_page = 10;


    /**
     * show the stock list
     * @param mixed $productId
     *
     * @return [type]
     */
    public function stockList(Request $request,$productId){

        $validator = Validator::make(['productId'=> $productId],['productId'=>'string|exists:products,id']);
        if($validator->fails()){
            return back();
        }

        $stocks = Stock::where('product_id',$productId)
                                        ->where('barcode','LIKE','%'. $request->search . '%')
                                            ->orderBy('created_at','DESC')->paginate($this->per_page)
                                                ->withQueryString();

        return view('product.stock.stockList')->with([
            'stocks'=> $stocks,
            'count' => $stocks->total(),
            'type' => $productId,
        ]);
    }

    /**
     * Realtime search
     * @param Request $request
     *
     * @return [type]
     */
    public function realTimeSearchStock(Request $request){

        $searchStocks = DB::table('stocks')->select(['name','id'])->where('name','LIKE','%' . $request->search . '%')->limit(8)->get();

        return response()->json(array(
            "status" => empty($searchStocks) ? false : true,
            "error" => null,
            "provider" => $searchStocks,
        ));
    }

    /**
     * Stock info AJAX
     * @param mixed $stockId
     *
     * @return [type]
     */
    public function stockInfo($stockId){

        $validator = Validator::make(['id' => $stockId],['id'=>'exists:stocks,id']);

        if($validator->fails()){
            return response()->json([
                'error'=>true,
                'messages'=> $validator->errors(),
            ]);
        }

        $stock = Stock::where('id',$stockId)->first();
        $stock->makeHidden(['id','updated_at','product_id']);


        return response()->json([
            "error" => false,
            "stock" => [
                'info' => $stock,
                'labels' => [
                    __('sold'),
                    __('left'),
                    __('expired'),
                    __('damaged'),
                ],
            ],
        ]);
    }
}
