<?php

namespace App;

use App\Events\product\product\ProductCreatedEvent;
use App\Events\product\product\ProductDeletedEvent;
use App\Events\product\product\ProductUpdatedEvent;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    protected $fillable =[
        'type_id','name','description','min_quantity','thumbnail',
    ];

    protected $dispatchesEvents = [
        'created' => ProductCreatedEvent::class,
        'deleted' => ProductDeletedEvent::class,
        'updated' => ProductUpdatedEvent::class,
    ];

    /**
     * path of default thumbnail for product
     * @var string
     */
    protected $defaultThumbnail = '/img/thumbnail-unknown.jpeg';

     /**
     * path of default minify thumbnail for product
     * @var string
     */
    protected $defaultMinify = '/img/minify-unknown.jpeg';

    /**
     * product Type relationship
     * @return [type]
     */
    public function productType(){
        return $this->belongsTo('App\ProductType','type_id');
    }

    /**
     * product stock relationship
     * @return [type]
     */
    public function stocks(){
        return $this->hasMany('App\Stock');
    }


    /**
     * get thumbnail or default minify/
     * @param mixed $minify=false
     *
     * @return [type]
     */
    public function getthumbnail($minify=false){
        if($minify){
            $path =  ($this->thumbnail) ? "/minify" . '/' . $this->thumbnail : $this->defaultMinify;
        }else{
            $path = ($this->thumbnail) ? "/thumbnail" . '/' . $this->thumbnail : $this->defaultThumbnail;
        }

        return $path;
    }

    /**
     * Return a minimal description
     * @param mixed $wordCount=10
     *
     * @return [type]
     */
    public function miniDescription($wordCount=5){

        return implode(
            '',
            array_slice(
                preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $this->description,$wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                ),
                0,
                $wordCount*2-1
                )
            ) . '...';

    }
}
