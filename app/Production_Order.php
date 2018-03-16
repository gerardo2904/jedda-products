<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production_Order extends Model
{
    protected $table = 'production_order';

    protected $primaryKey = 'id_production';

    public $timestamps = true;

    protected $fillable = [
    		'id_producto_mp',
            'etiqueta_mp',
            'id_producto_core',
            'etiqueta_core',
            'id_producto_leader1',
            'etiqueta_leader1',
            'id_producto_leader2',
            'etiqueta_leader2',
            'id_producto_sticker',
            'etiqueta_sticker',
            'direction',
            'id_user',
            'id_company',
            'fecha_hora',
            'estado'
    ];

    protected $guarded = [
    ];
}
