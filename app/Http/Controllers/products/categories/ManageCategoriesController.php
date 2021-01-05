<?php

namespace App\Http\Controllers\products\categories;

use App\Http\Controllers\Controller;
use App\Jobs\updateMosaicProductType;
use App\ProductType;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageCategoriesController extends Controller
{
    use ItemTrait;

    protected $per_page = 10;

     /**
     * show a list of different categories of product
     * @return [type]
     */
    public function productsCategoryList(Request $request){

        // !! UPDATE THE MOSAIC !!!!
        // updateMosaicProductType::dispatch()->delay(now()->addMinutes(1));

        $categories = ProductType::where('type','LIKE','%'. $request->search . '%')
                                     ->orderBy('created_at','DESC')->paginate($this->per_page)
                                        ->withQueryString();

        foreach ($categories as $category) {
                $category->count = $category->products()->count();
        }

        return view('product.category.productCategoryList')->with([
            'categories' => $categories,
            'count' => $categories->total(),
        ]);
    }

    /**
     * Realtime search
     * @param Request $request
     *
     * @return [type]
     */
    public function realTimeSearchCategory(Request $request){

        $searchCategories = DB::table('product_types')->select(['type','id'])->where('type','LIKE','%' . $request->search . '%')->limit(8)->get();

        return response()->json(array(
            "status" => empty($searchCategories) ? false : true,
            "error" => null,
            "category" => $searchCategories,
        ));
    }

    /**
     * Get category of product AJAX
     * @param mixed $itemId
     * @return [type]
     */
    public function getCategory($categoryId){

        $validator = $this->isValidItem('product_type',$categoryId);

        if($validator->success){

        $category = ProductType::where('id',$categoryId)->first();

        //return array with key as id of the input field in the modal form
        return response()->json([
            'success' => true,
            'inputs' => [
                'UpdateCategory' => $category->type,
            ],
        ]);
       }else{
           return response()->json($validator);
       }
    }

     /**
     * Provider info AJAX
     * @param mixed $categoryId
     *
     * @return [type]
     */
    public function categoryInfo($categoryId){

        $validator = $this->isValidItem('product_type',$categoryId);

        if($validator->success){
            $category = ProductType::where('id',$categoryId)->first();

            $fieldProductCount = 20;
            $fieldItemCount = 2000;
            $fieldItemSold = 1900;
            $fieldItemExpired = 20;
            $fieldItemDamaged = 10;
            $fieldItemLeft = 70;

            return response()->json([
                "success" => true,
                "category" => [
                    'title' => __('category'),
                    'info' => [
                        'fieldName' => $category->type,
                        'fieldProductCount' => $fieldProductCount,
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
}
