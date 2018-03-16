<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleProductionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_production_order', function (Blueprint $table) {
            $table->increments('id_detalle_order');
            $table->integer('id_production');
            $table->integer('corrida');
            $table->integer('id_producto_pt');
            $table->string('etiqueta_pt');
            $table->string('cantidad_pt');
            $table->integer('id_user');
            $table->boolean('estado_pt')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_production_order');
    }
}
