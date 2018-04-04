<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeader3ProductionOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_order', function (Blueprint $table) {
            $table->integer('id_producto_leader3')->after('etiqueta_leader2');
            $table->string('etiqueta_leader3')->after('id_producto_leader3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_order', function (Blueprint $table) {
            $table->dropColumn('id_producto_leader3');
            $table->dropColumn('etiqueta_leader3');
        });
    }
}
