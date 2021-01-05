<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Jobs\resizeThumbnails;
use App\Jobs\sendNotificationToAllAdminUser;
use App\Product;
use App\ProductType;
use App\Traits\ItemTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic;
use Symfony\Component\HttpFoundation\File\File;

class AddNewProductController extends Controller
{
    protected $rules = [
        'name' => ['required','unique:products','string','regex:/^[a-zA-Z0-9\_\-éèçà\&\'\"\(\)\, ]+$/','max:50'],
        'type_id' => ['required','exists:product_types,id'],
        'minQuantity' => ['required','numeric','min:0'],
        'thumbnail' => ['image','nullable','mimes:jpeg,png','max:8000'],
        'description' => ['string','regex:/^[a-zA-Z0-9_\-èé,\. ]+$/','max:500'],
    ];

    /**
     * Add new product to the DB
     * @param Request $request
     *
     * @return [type]
     */
    public function addNewProduct(Request $request){

        $validator = Validator::make($request->all(),$this->rules);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

           $product = [
            'name'=> ucfirst($request->name),
            'type_id'=> $request->type_id,
            'min_quantity'=> $request->minQuantity,
            'description'=> $request->description
        ];

        if($request->thumbnail){

                    $thumbnailPath = public_path('thumbnail/thumbnail-' . $request->name . '-' . time() . '.' . $request->thumbnail->extension());
                    $minifyPath = public_path('minify/' . basename($thumbnailPath));
                    $thumbnailSize = 200;
                    $minifySize = 64;

                    if(ImageManagerStatic::make($request->thumbnail)->resize($thumbnailSize,$thumbnailSize)->save($thumbnailPath)){

                        //dispatch the thumbnail minification job
                        resizeThumbnails::dispatch($thumbnailPath,$minifyPath,$minifySize);

                        $product['thumbnail'] = basename($thumbnailPath);
                    }

                }

                if($newProduct = Product::create($product)){
                    //start a new job of sending notification to all superadmin and admin
                    sendNotificationToAllAdminUser::dispatch(($newProduct));
                }

        //use created event dispatcher in Product model
        // broadcast(new ProductCreatedEvent($productType));

        return response()->json(['success'=> true]);


    }

}
