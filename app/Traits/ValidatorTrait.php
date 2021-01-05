<?php

namespace App\Traits;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ValidatorTrait
{
     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Username validation rules.
     * @var array
     */
    protected $usernameValidator = ['required','unique:users','string','regex:/^[a-zA-Z0-9_@]+$/','max:50'];

    /**
     * password validation rules.
     * @var array
     */
    protected $passwordValidator = [];
    /**
     * password confirmation rules.
     * @var array
     */
    protected $passwordConfirmValidator = [];

    /**
     * set username validation rule in the proccess of input validations.
     * @param array $rules
     *
     * @return [type]
     */
    public function setUsernameValidationRule(array $rules){
        if($this->usernameValidator = $rules)
            return true;
        else
            return false;
    }

    /**
     * set password validation rule in the proccess of input validations.
     * @param array $rules
     *
     * @return [type]
     */
    public function setPasswordValidationRule(array $rules){
        if($this->passwordValidator = $rules)
            return true;
        else
            return false;
    }


    /**
     * set a validation object for user input validations.
     * @param array $data
     *
     * @return [type]
     */
    public function validator(array $data)
    {
        $validRole = [];
        $roles =  Role::where('name','!=','superAdmin')->get('name');
        foreach ($roles as  $role) {
            $validRole [] = $role->name;
        }

        $rules = [
            'username' => $this->usernameValidator,
            'firstname' => ['required', 'string', 'max:100','regex:/^[a-zA-Zéeç ]+$/'],
            'lastname' => ['required', 'max:60','regex:/^[a-zA-Zéeç]+$/'],
            'role' => ['required', Rule::in($validRole)],
            'image' => ['image','nullable','mimes:jpeg,png','max:8000'],
            'telephone' => ['string','nullable','min:9', 'max:20','regex:/^[\+]*[0-9]+$/'],
            'address' => ['string','nullable','max:100','regex:/^[a-zA-Z0-9,\. ]+$/'],
            'email' => ['string','nullable', 'email', 'max:100'],
            'password' => $this->passwordValidator,
            'password_confirm' => $this->passwordConfirmValidator,
        ];
        return Validator::make($data,$rules);
    }



}
