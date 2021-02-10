<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductType;
use App\Jobs\updateMosaicProductType;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ManageProductsController extends Controller
{
    use ItemTrait;

    protected $per_page = 10;

     /**
     * show a list of different products present in a category
     * @return [type]
     */
    public function productsList(Request $request, $categoryId){

        $validator = Validator::make(['id' => $categoryId],['id' => 'exists:product_types,id']);

        if($validator->fails()){
           return redirect()->back();
        }
        $products = Product::where('type_id',$categoryId)->where('name','LIKE','%'. $request->search . '%')
                                                        ->orderBy('created_at','DESC')->paginate($this->per_page)
                                                        ->withQueryString();
                                                        // ->withPath("?search=" . $request->search);

        return view('product.Productslist')->with([
            'products' => $products,
            'count' => $products->total(),
            'category' => ProductType::find($categoryId),
        ]);
    }

    /**
     * Get product data to fill the form update modal AJAX
     * @param mixed $itemId
     * @return [type]
     */
    public function getProduct($productId){

        $validator = $this->isValidItem('product',$productId);

        if($validator->success){

        $product = Product::where('id',$productId)->first();

        //return array with key as id of the input field in the modal form
        return response()->json([
            'success' => true,
            'inputs' => [
                'updatename' => $product->name,
                'updateminQuantity' => $product->min_quantity,
                'updatedescription' => $product->description,
                'updateimagePreview' => $product->getthumbnail(),
            ],
        ]);

       }else{
           return response()->json($validator);
       }
    }

     /**
     * Product info AJAX
     * @param mixed $productId
     *
     * @return [type]
     */
    public function productInfo($productId){

        $validator = $this->isValidItem('product',$productId);

        if($validator->success){
            $product = Product::where('id',$productId)->first();

            $fieldStockCount = 20;
            $fieldAvailableCount = 2;
            $fieldOutOfStockCount = 18;
            $fieldItemCount = 2000;
            $fieldItemSold = 1900;
            $fieldItemExpired = 20;
            $fieldItemDamaged = 10;
            $fieldItemLeft = 70;

            return response()->json([
                "success" => true,
                "product" => [
                    'title' => __('product'),
                    'info' => [
                        'fieldName' => $product->name,
                        'fieldStockCount' => $fieldStockCount,
                        'fieldAvailableCount' => $fieldAvailableCount,
                        'fieldOutOfStockCount' => $fieldOutOfStockCount,
                        'fieldItemCount' => $fieldItemCount,
                        'fieldItemSold' => $fieldItemSold,
                        'fieldItemExpired' => $fieldItemExpired,
                        'fieldItemDamaged' => $fieldItemDamaged,
                        'fieldItemLeft' => $fieldItemLeft,
                    ],
                    'data' => [
                        __('Item sold') => $fieldItemSold,
                        __('Item expired') => $fieldItemExpired,
                        __('Item damaged') => $fieldItemDamaged,
                        __('Item left') => $fieldItemLeft,
                    ],
                ],
            ]);

        }else{
            return response()->json($validator);
        }


    }

    /**
     * Realtime search
     * @param Request $request
     *
     * @return [type]
     */
    public function realTimeSearchProduct(Request $request){

        $searchProducts = DB::table('products')->select(['name','thumbnail', 'type_id'])->where('name','LIKE','%' . $request->search . '%')->limit(8)->get();

        return response()->json(array(
            "status" => empty($searchProducts) ? false : true,
            "error" => null,
            "product" => $searchProducts,
        ));
    }

    public function deleteUserNotifications(Request $request){

        $request->user()->notifications()->delete();

        // header('content-Type : application/json');

       return response()->json(array(
            "number" => auth()->user()->notifications->count(),
            "error" => null,
        ));
    }

}
