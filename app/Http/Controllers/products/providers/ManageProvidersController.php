<?php

namespace App\Http\Controllers\products\providers;

use App\Http\Controllers\Controller;
use App\Provider;
use App\Traits\ItemTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

class ManageProvidersController extends Controller
{
    use ItemTrait;

    protected $per_page = 10;

    public function providerList(Request $request){

        $providers = Provider::where('name','LIKE','%'. $request->search . '%')
                            ->orderBy('created_at','DESC')->paginate($this->per_page)
                            ->withQueryString();

        return view('product.provider.providerList')->with([
            'providers' => $providers,
            'count' => $providers->count(),
            ]);

    }

    /**
     * Realtime search
     * @param Request $request
     *
     * @return [type]
     */
    public function realTimeSearchProvider(Request $request){

        $searchProviders = DB::table('providers')->select(['name','id'])->where('name','LIKE','%' . $request->search . '%')->limit(8)->get();

        return response()->json(array(
            "status" => empty($searchProviders) ? false : true,
            "error" => null,
            "provider" => $searchProviders,
        ));
    }

    /**
     * Get provider AJAX
     * @param mixed $itemId
     * @return [type]
     */
    public function getProvider($providerId){

        $validator = $this->isValidItem('provider',$providerId);

        if($validator->success){

        $provider = Provider::where('id',$providerId)->first();

        //return array with key as id of the input field in the modal form
        return response()->json([
            'success' => true,
            'inputs' => [
                'UpdateProviderName' => $provider->name,
                'UpdateProviderAddress' => $provider->address,
                'UpdateProviderEmail' => $provider->email,
                'UpdateProviderTelephone1' => $provider->telephone1,
                'UpdateProviderTelephone2' => $provider->telephone2,
            ],
        ]);
       }else{
           return response()->json($validator);
       }
    }


    /**
     * Provider info AJAX
     * @param mixed $providerId
     *
     * @return [type]
     */
    public function providerInfo($providerId){

        $validator = $this->isValidItem('provider',$providerId);

        if($validator->success){
            $provider = Provider::where('id',$providerId)->first();

            $fieldItemCount = 2000;
            $fieldItemSold = 1900;
            $fieldItemExpired = 20;
            $fieldItemDamaged = 10;
            $fieldItemLeft = 70;

            return response()->json([
                "success" => true,
                "provider" => [
                    'title' => __('provider'),
                    'info' => [
                        'fieldName' => $provider->name,
                        'fieldAddress' => $provider->address,
                        'fieldEmail' => $provider->email,
                        'fieldTelephone1' => $provider->telephone1,
                        'fieldTelephone2' => $provider->telephone2,
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

    public function realTimeSearchProduct(Request $request){

        $searchProviders = DB::table('providers')->select(['name'])->where('name','LIKE','%' . $request->search . '%')->limit(8)->get();

        header('content-Type : application/json');

        echo json_encode(array(
            "status" => empty($searchProviders) ? false : true,
            "error" => null,
            "provider" => $searchProviders,
        ));
    }
}
