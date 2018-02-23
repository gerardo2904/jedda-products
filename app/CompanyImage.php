<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyImage extends Model
{
 public function company()
    {
        return $this->belongsTo(Company::class);
    }
	
	//accesor
	public function getUrlAttribute(){
		if (substr($this->image,0,4) === "http"){
			return $this->image;
		}
		
		return '/images/companies/' . $this->image;
	}
}
