<?php

namespace App\Http\Controllers\products\providers;

use App\Events\provider\ProductProviderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Provider;
use App\Traits\ItemTrait;
use App\Traits\UpdateModelTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UpdateProviderController extends Controller
{
    use ItemTrait;

    protected $rules = [
        'name' => ['string','regex:/^[a-zA-Z0-9 ]+$/'],
        'email' => ['nullable','email'],
        'address' => ['nullable','regex:/^[a-zA-Z0-9,@çèé\-\_ ]+$/'],
        'telephone1' => ['nullable','string','regex:/^\+?[0-9 ]+$/'],
        'telephone2' => ['nullable','string','regex:/^\+?[0-9 ]+$/'],
    ];


    public function UpdateProvider(Request $request,$providerId){

        $newModal = [
            'name' => $request->UpdateProviderName,
            'email' => $request->UpdateProviderEmail,
            'address' => $request->UpdateProviderAddress,
            'telephone1' => $request->UpdateProviderTelephone1,
            'telephone2' => $request->UpdateProviderTelephone2,
        ];
        $uniqueField =[
            'name',
        ];

        return response()->json($this->updateItem('provider',$providerId,$this->rules,$newModal,$uniqueField));

    }
}
