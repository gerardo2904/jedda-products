<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoNcantidadProdAlmproductsTempo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('almproducts_tempo', function (Blueprint $table) {
            $table->float('ncantidad_prod')->after('cantidad_prod');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('almproducts_tempo', function (Blueprint $table) {
            $table->dropColumn('ncantidad_prod');
        });
    }
}
