<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlmproductsTempoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('almproducts_tempo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_production');
            $table->integer('id_company');
            $table->integer('id_product');
            $table->float('existencia');
            $table->float('precioc');
            $table->float('preciov');
            $table->integer('id_unidad_prod');
            $table->float('cantidad_prod');
            $table->string('etiqueta');
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
        Schema::dropIfExists('almproducts_tempo');
    }
}
