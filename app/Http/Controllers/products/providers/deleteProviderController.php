<?php

namespace App\Http\Controllers\products\providers;

use App\Http\Controllers\Controller;
use App\Provider;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class deleteProviderController extends Controller
{
    use ItemTrait;

    public function deleteMultipleProvider(Request $request){

        return $this->deleteMultipleItem('provider',$request);

    }
}
