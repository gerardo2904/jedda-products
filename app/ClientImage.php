<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientImage extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
	
	//accesor
	public function getUrlAttribute(){
		if (substr($this->image,0,4) === "http"){
			return $this->image;
		}
		
		return '/images/clients/' . $this->image;
	}
}
