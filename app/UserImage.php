<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	//accesor
	public function getUrlAttribute(){
		if (substr($this->image,0,4) === "http"){
			return $this->image;
		}
		
		return '/images/users/' . $this->image;
	}
}
