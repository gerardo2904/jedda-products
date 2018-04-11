<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCampoDescuentoVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('detalle_venta', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE detalle_venta MODIFY descuento  DECIMAL(10,3) null'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_venta', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE detalle_venta CHANGE descuento descuento FLOAT(10,2)'));
        });
    }
}
