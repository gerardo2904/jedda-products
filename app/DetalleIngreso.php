<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'detalle_ingreso';

    protected $primaryKey = 'iddetalle_ingreso';

    public $timestamps = false;

    protected $fillable = [
    		'iddetalle_ingreso',
            'idingreso',
            'id_empresa',
            'id_articulo',
            'cantidad',
            'precioc',
            'id_unidad_prod',
            'cantidad_prod',
            'etiqueta'

    ];

    protected $guarded = [
    ];}
