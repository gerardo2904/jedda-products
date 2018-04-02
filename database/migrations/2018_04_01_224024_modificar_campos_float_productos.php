<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCamposFloatProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE products CHANGE cantidad_prod cantidad_prod DECIMAL(10,3)'));
            DB::update(DB::raw('ALTER TABLE products CHANGE ancho_prod ancho_prod DECIMAL(10,3)'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE products CHANGE cantidad_prod cantidad_prod FLOAT(10,2)'));
            DB::update(DB::raw('ALTER TABLE products CHANGE ancho_prod ancho_prod FLOAT(10,2)'));
        });
    }
}

