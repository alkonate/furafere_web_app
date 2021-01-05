<?php

namespace App;

use App\Traits\UpdateModelTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use UpdateModelTrait;

    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
