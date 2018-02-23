<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    	
    public function images()
    {
        return $this->hasMany(ClientImage::class);
    }
	
	public function getFeaturedImageUrlAttribute(){
		$featuredImage = $this->images()->where('featured', true)->first();
		if (!$featuredImage){
			$featuredImage = $this->images()->first();
		}
		
		if ($featuredImage){
			return $featuredImage->url;
		}
		
		//default
		return '/images/clients/user-default.png';
	}
}
