<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCamposFloatAlmproducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('almproducts', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE almproducts CHANGE cantidad_prod cantidad_prod DECIMAL(10,3)'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('almproducts', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE almproducts CHANGE cantidad_prod cantidad_prod FLOAT(10,2)'));
        });
    }
}
