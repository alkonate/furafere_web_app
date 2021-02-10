<?php

namespace App\Http\Controllers\products\stocks;

use App\Http\Controllers\Controller;
use App\Product;
use App\Provider;
use App\Stock;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageStocksController extends Controller
{
    use ItemTrait;

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

        if($request->stock=='available'){
            $stocks = Stock::where('product_id',$productId)
                                        ->whereHas('items',function($query){
                                            $query->where(function($query){
                                                    $query->where('expired',null)->orWhere('expired',false);
                                                })->where(function($query){
                                                    $query->where('out_of_stock',null)->orWhere('out_of_stock',false);
                                                });
                                        })
                                        ->orderBy('created_at','DESC')->paginate($this->per_page)
                                            ->withQueryString();
        }elseif($request->stock=='expired'){

            $stocks = Stock::where('product_id',$productId)
                                        ->whereHas('items',function($query){
                                            $query->where('expired',true);
                                        })
                                        ->orderBy('created_at','DESC')->paginate($this->per_page)
                                            ->withQueryString();

        }elseif($request->stock=='out_of_stock'){
            $stocks = Stock::where('product_id',$productId)
                                        ->whereHas('items',function($query){
                                            $query->where('out_of_stock',true);
                                        })
                                        ->orderBy('created_at','DESC')->paginate($this->per_page)
                                            ->withQueryString();
        }else{// all
            if($request->has('search')){
                $stocks = Stock::where('product_id',$productId)
                ->where('barcode',$request->search)
                ->orderBy('created_at','DESC')->paginate($this->per_page)
                    ->withQueryString();
            }else{
                $stocks = Stock::where('product_id',$productId)
                            ->orderBy('created_at','DESC')->paginate($this->per_page)
                                ->withQueryString();
            }

        }

        return view('product.stock.stockList')->with([
            'stocks'=> $stocks,
            'count' => $stocks->total(),
            'product' => $Product = Product::find($productId),
            'category' => $Product->productType,
        ]);
    }

    /**
     * Realtime search
     * @param Request $request
     *
     * @return [type]
     */
    public function realTimeSearchStock(Request $request){

        $searchStocks = DB::table('stocks')->select(['product_id','barcode'])
                                            ->where('barcode','LIKE','%' . $request->search . '%')
                                            ->limit(8)
                                            ->get();

        return response()->json(array(
            "status" => empty($searchStocks) ? false : true,
            "error" => null,
            "stock" => $searchStocks,
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

    /**
     * Get stock data to fill the update stock form.
     * @return object
     */
    public function getStock($stockId){

        $validator = $this->isValidItem('stock',$stockId);

        if($validator->success){

        $stock = Stock::where('id',$stockId)->first();

        //return array with key as id of the input field in the modal form
        return response()->json([
            'success' => true,
            'inputs' => [
                'id' => $stock->id,
                'barcode' => $stock->barcode,
                'providerId' => $stock->provider_id,
                'buyingPriceUnit' => $stock->prices->buying_price_unit,
                'sellingPriceUnit' => $stock->prices->selling_price_unit,
                'items' => $this->stockItemsArray($stock),
                ],
        ]);

       }else{
           return response()->json($validator);
       }
    }

    /**
     * Get the stock items array.
     * @param Stock $stock
     *
     * @return [type]
     */
    protected function stockItemsArray(Stock $stock){
        $itemsArray = [];
        $i=0;
        foreach ($stock->items as $item) {
            $itemsArray [] = [
                'itemId'.$i => $item->id,
                'itemCount'.$i => $item->quantity,
                'expireDate'.$i => $item->expired_at,
            ];
            $i++;
        }

        return $itemsArray;
    }
}
