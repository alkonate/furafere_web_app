<?php

namespace App\Http\Controllers\products\categories;

use App\Http\Controllers\Controller;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;

class UpdateCategoryController extends Controller
{
    use ItemTrait;

    protected $rules = [
        'UpdateCategory' => ['string','regex:/^[a-zA-Z0-9 ]+$/'],
    ];


    public function UpdateCategory(Request $request,$categoryId){

        $newModal = [
            'type' => $request->UpdateCategory,
        ];
        $uniqueField =[
            'type',
        ];

        return $this->updateItem('product_type',$categoryId,$this->rules,$newModal,$uniqueField,'UpdateCategory');

    }
}
