<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model
{
       
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
	
	//accesor
	public function getUrlAttribute(){
		if (substr($this->image,0,4) === "http"){
			return $this->image;
		}
		
		return '/images/categories/' . $this->image;
	}
}
