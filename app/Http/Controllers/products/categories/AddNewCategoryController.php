<?php

namespace App\Http\Controllers\products\categories;

use App\Http\Controllers\Controller;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddNewCategoryController extends Controller
{
    public function addNewCategory(Request $request){

        $validator = Validator::make($request->all(),[
            'ProductType' => ['string','unique:product_types,type','regex:/^[a-zA-Z0-9 ]+$/'],
        ]);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

        ProductType::create([
            'type' => $request->ProductType,
        ]);

        //use created event dispatcher in ProductType model
        // broadcast(new ProductCategoryCreatedEvent($productType));

        return response()->json(['success'=> true]);
    }
}
