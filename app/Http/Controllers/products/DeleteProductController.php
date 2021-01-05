<?php

namespace App\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    use ItemTrait;

    public function deleteMultipleProduct(Request $request){

        return $this->deleteMultipleItem('product',$request);

    }
}
