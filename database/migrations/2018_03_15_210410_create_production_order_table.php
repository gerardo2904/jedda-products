<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_order', function (Blueprint $table) {
            $table->increments('id_production');
            $table->integer('id_producto_mp');
            $table->string('etiqueta_mp');
            $table->integer('id_producto_core');
            $table->string('etiqueta_core');
            $table->integer('id_producto_leader1');
            $table->string('etiqueta_leader1');
            $table->integer('id_producto_leader2');
            $table->string('etiqueta_leader2');
            $table->integer('id_producto_sticker');
            $table->string('etiqueta_sticker');
            $table->string('direction');
            $table->integer('id_user');
            $table->integer('id_company');
            $table->datetime('fecha_hora');
            $table->string('estado');
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
        Schema::dropIfExists('production_order');
    }
}
