<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Cart;


            
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
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
		return '/images/users/user-default.png';
	}

	public function carts(){
		return $this->hasMany(Cart::class);
	}

	
	// cart_id
	public function getCartAttribute(){
		$cart = $this->carts()->where('status','Active')->first();
		
		if ($cart)
			return $cart;
		
		//else
		$cart = new Cart();
		$cart->status  = 'Active';
		$cart->user_id = $this->id;
		$cart->save();
		
		return $cart;
	}
}
