<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // $category-> products
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function images()
    {
        return $this->hasMany(CategoryImage::class);
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
		return '/images/categories/default.png';
	}

}
