<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Production_Order extends Model
{
   protected $table = 'detalle_production_order';

    protected $primaryKey = 'id_detalle_order';

    public $timestamps = false;

    protected $fillable = [
    		'id_detalle_order',
    		'id_production',
    		'corrida',
    		'id_producto_pt',
    		'etiqueta_pt',
    		'cantidad_pt',
    		'id_user',
    		'estado_pt'
    ];

    protected $guarded = [
    ];
}
