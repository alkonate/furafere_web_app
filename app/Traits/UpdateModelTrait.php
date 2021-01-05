<?php

namespace App\Traits;

use Exception;
use Psy\CodeCleaner\ReturnTypePass;

trait UpdateModelTrait
{

    /**
     * Update only the model attribute(s) not their values in the DB.
     * @param array $data
     *
     * @return [type]
     */
    public function updateModel(array $data,$nullable=true){
        foreach ($data as $key => $value) {
            if($this->hasAttribute($key)){
                if($this->$key != $value){
                    if($nullable || !($nullable && empty($value))){
                        $this->$key = $value;
                    }
                }
            }else{
                throw new Exception("Invalid attribute name $key for the model class " . get_class($this) . '.');
            }
        }

        return true;
    }

    /**
     * check if a model has an attribute
     * @param string $attr
     *
     * @return boolean
     */
    public function hasAttribute (string $attr){
        $attrs = $this->attributes;

        foreach ($attrs as $key => $value) {
            if($attr == $key){
                return true;
                die();
            }
        }
        return false;
    }
}
