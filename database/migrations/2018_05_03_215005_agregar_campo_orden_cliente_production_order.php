<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoOrdenClienteProductionOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_order', function (Blueprint $table) {
            $table->string('orden_cliente')->after('orden');
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
            $table->dropColumn('orden_cliente');
        });
    }
}
