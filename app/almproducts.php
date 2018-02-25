<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class almproducts extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
