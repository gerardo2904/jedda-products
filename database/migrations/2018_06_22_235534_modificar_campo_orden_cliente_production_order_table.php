<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCampoOrdenClienteProductionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('production_order', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE production_order MODIFY orden_cliente  VARCHAR(191) null'));
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
            DB::update(DB::raw('ALTER TABLE production_order CHANGE orden_cliente orden_cliente VARCHAR(191)'));
        });
    }
}


