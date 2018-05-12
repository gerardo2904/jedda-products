<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class almproducts_tempo extends Model
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

    protected $table = 'almproducts_tempo';

    protected $primaryKey = 'id';

    //public $timestamps = false;

    protected $fillable = [
    		'id_production',
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
