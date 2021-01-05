<?php

namespace App\Http\Controllers\products\providers;

use App\Events\ProductProviderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddNewProviderController extends Controller
{
    public function addNewProvider(Request $request){

        $validator = Validator::make($request->all(),[
            'ProviderName' => ['string','unique:providers,name','regex:/^[a-zA-Z0-9 ]+$/'],
            'ProviderEmail' => ['nullable','email'],
            'ProviderAddress' => ['nullable','regex:/^[a-zA-Z0-9,@çèé\-\_ ]+$/'],
            'ProviderTelephone1' => ['nullable','string','regex:/^[0-9 ]+$/'],
            'ProviderTelephone2' => ['nullable','string','regex:/^[0-9 ]+$/'],
        ]);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }

        Provider::create([
            'name' => $request->ProviderName,
            'email' => $request->ProviderEmail,
            'address' => $request->ProviderAddress,
            'telephone1' => $request->ProviderTelephone1,
            'telephone2' => $request->ProviderTelephone2,
        ]);

        //use created event dispatcher in provider model
        // broadcast(new ProductProviderCreatedEvent($provider));

        return response()->json(['success'=> true]);
    }
}
