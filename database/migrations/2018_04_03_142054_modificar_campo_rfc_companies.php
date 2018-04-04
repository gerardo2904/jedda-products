<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarCampoRfcCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE companies MODIFY rfc VARCHAR(191) null'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('companies', function (Blueprint $table) {
            DB::update(DB::raw('ALTER TABLE companies MODIFY rfc VARCHAR(191)'));
        });
    }
}
