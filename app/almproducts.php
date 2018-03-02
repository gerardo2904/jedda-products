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

    protected $table = 'almproducts';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
            'id_company',
            'id_product',
            'existencia',
            'precioc',
            'preciov',
            'id_unidad_prod',
            'cantidad_prod'
    ];

    protected $guarded = [
    ];

}
