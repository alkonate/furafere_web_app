<?php

namespace App\Traits;

use Intervention\Image\ImageManagerStatic;

trait UploadImageTrait
{

    //the default profil image
    protected $defaultImageURL = '/img/unknown.jpg';


    public function uploadProfilImage($image,$path){
        return ImageManagerStatic::make($image)->resize(200,200)->save($path)->basePath();
    }


    public function getImage(){

            return ($this->image)  ? $this->image->image_url : $this->defaultImageURL;

    }

}
