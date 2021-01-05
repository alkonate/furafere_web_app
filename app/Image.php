<?php

namespace App;

use App\Traits\UpdateModelTrait;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    use UpdateModelTrait;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id','image_url'
    ];

    //relationship
    public function user(){
        return $this->belongsTo('App\User');
    }

}
