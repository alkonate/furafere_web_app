<?php

namespace App\Traits;

use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use stdClass;

trait ItemTrait
{

    /**
     * delete one or multiple item(modal,product...) ajax only.
     * @param mixed $item
     * item name you want to delete min sing.
     * @param mixed $request
     *request object received.
     * @return array
     */
    public function deleteMultipleItem($item,$request){
        if(Hash::check($request->deleteItemPasswordInput,auth()->user()->password)){

            $rules = [
                ['id' => 'exists:'.$item.'s,id']
            ];

            $modelName = 'App\\'. ucfirst(Str::camel($item));

            foreach($request->id as $id){
                $validator = Validator::make(['id' => $id,],$rules);

                if($validator->fails()){
                    return [
                        'error' => true,
                        'messages' => __('notyf.invalid.item',['item'=>$item,'id'=>$id]),
                    ];
                    die();
                }

                $modelName::find($id)->delete();

               }

               return [
                'success' => true,
                ];

            }else{
               return [
                   'invalid' => true,
                   'messages' => ['deleteItemPasswordInput' => __('Invalid password.')],
               ];
            }
    }


    /**
     * Update the any item (provider,product...) ajax only.
     * @param string $item
     * item name
     * @param string $id
     * item id
     * @param array $rules
     * validator rules.
     * @param array $newModal
     * modal value that need to be updated.
     * @param array $unique
     * modal field set to unique in the database.
     * @param string $uniqueInputId=''
     * form input unique id
     * @return [type]
     */
    public function updateItem($item,$id,$rules,$newModal,$unique,$uniqueInputId=''){

        $validator = Validator::make($newModal,$rules);

        if($validator->fails()){
            return response()->json([
                'invalid' => true,
                'messages' => $validator->errors(),
                ]);
        }
        $modelName = 'App\\'. Str::camel(ucfirst($item));

        if($modal = $modelName::where('id',$id)->first()){

            foreach ($unique as $field) {
                if($modal->$field != $newModal[$field] && $modelName::where($unique[0],$newModal[$field])->first()){

                    $messages = empty($uniqueInputId) ? [
                        'Update'.ucfirst($item).ucfirst($field) => __('validation.unique',['attribute'=>$item]),
                    ] : [
                        $uniqueInputId => __('validation.unique',['attribute'=>$item]),
                    ];

                    return response()->json([
                        'invalid' => true,
                        'messages' => $messages,

                        ]);
                }
            }

            $modal->update($newModal);
            //broadcoast ProductProviderUpdatedEvent
            // broadcast(new ProductProviderUpdatedEvent($modal));

            return response()->json([
                'success' => true,
            ]);
        }

    }

    /**
     * check whatever or not an item exist into the DB.
     * @param string $item
     * item name
     * @param string $itemId
     * item id
     * @return [type]
     */
    public function isValidItem($item,$itemId){

        $validator = Validator::make(['id' => $itemId,],['id' => 'exists:'.$item.'s,id']);
        $response = new stdClass();

        if($validator->fails()){
                $response->success = false;
                $response->messages = __('notyf.invalid.item',['item'=>$item,'id'=>$itemId]);
        }else{
            $response->success = true;
        }

        return $response;
    }


}
