<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Jobs\resizeThumbnails;
use App\Product;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic;

class UpdateProductController extends Controller
{
    use ItemTrait;

    protected $rules = [
        'name' => ['required','string','regex:/^[a-zA-Z0-9 ]+$/'],
        'type_id' => ['required','exists:product_types,id'],
        'minQuantity' => ['required','numeric','min:0'],
        'thumbnail' => ['nullable','image','mimes:jpeg,png','max:8000'],
        'description' => ['string','regex:/^[a-zA-Z0-9_\-èé,\. ]+$/','max:500'],
    ];


    public function UpdateProduct(Request $request,$productId){

        $validator = Validator::make($request->all(),$this->rules);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

        if($product = Product::where('id',$productId)->first()){

                if($product->name != $request->name && Product::where('name',$request->name)->first()){

                    $messages = [
                        'Updatename' => __('validation.unique',['attribute'=>'name']),
                    ];

                    return response()->json([
                        'invalid' => true,
                        'messages' => $messages,
                        ]);
                }

                $updateProduct = [
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

                                $updateProduct['thumbnail'] = basename($thumbnailPath);
                                //delete the old image minify et thumbnail
                                Storage::delete($product->getthumbnail());
                                Storage::delete($product->getthumbnail(true));
                            }

                        }

                $product->update($updateProduct);

            //broadcoast ProductProviderUpdatedEvent
            //broadcast(new ProductProviderUpdatedEvent($product));

            return response()->json([
                'success' => true,
            ]);
         }

    }
}
