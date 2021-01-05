<?php

namespace App;

use App\Traits\UpdateModelTrait;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use UpdateModelTrait;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'firstname','lastname','telephone','email','address',
    ];

    public function user(){
        return $this->belongTo('App\User');
    }
}
