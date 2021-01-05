<?php

namespace App\Http\Controllers\products\categories;

use App\Http\Controllers\Controller;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;

class DeleteCategoryController extends Controller
{
    use ItemTrait;

    public function deleteMultipleCategory(Request $request){

        return $this->deleteMultipleItem('product_type',$request);

    }
}
