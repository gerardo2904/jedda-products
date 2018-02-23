<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function users()
    {
        return $this->hasMany(User::class);
    }
	
    public function images()
    {
        return $this->hasMany(CompanyImage::class);
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
		return '/images/companies/company-default.png';
	}
}
