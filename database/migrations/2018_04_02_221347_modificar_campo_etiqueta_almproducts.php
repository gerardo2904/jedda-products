<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCampoEtiquetaAlmproducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('almproducts', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE almproducts MODIFY etiqueta VARCHAR(191) null'));
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
            DB::update(DB::raw('ALTER TABLE almproducts MODIFY etiqueta VARCHAR(191)'));
        });
    }
}
