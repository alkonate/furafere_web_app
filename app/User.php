<?php

namespace App;

use App\Traits\UpdateModelTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable,UploadImageTrait,UpdateModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password','locked','password_updated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function info(){
        return $this->hasOne('App\Info');
    }

    public function roles(){
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function image(){
        return $this->hasOne('App\Image');
    }


    public function hasRoles(array $roles){
        return $this->roles()->whereIn('name',$roles)->first();
    }

    /**
     * check if the user has a role
     * @param string $role
     *
     * @return Role
     */
    public function hasRole(string $role){
        return $this->roles()->where('name',$role)->first();
    }

    /**
     * check if a user account is locked
     * @return boolean
     */
    public function isLock(){
        if(!$this->locked){
            return false;
        }else{
            return true;
        }
    }
    /**
     * check if the user is superAdmin user
     * @return [type]
     */
    public function isSuperAdmin(){
        return $this->hasRole('superadmin');
    }

    /**
     * lock user account
     * @return boolean
     */
    public function lock(){
         $this->locked = TRUE;
         return $this->save();
    }

    /**
     * unlock user account
     * @return boolean
     */
    public function unlock(){
        $this->locked = FALSE;
        return $this->save();
   }

}
