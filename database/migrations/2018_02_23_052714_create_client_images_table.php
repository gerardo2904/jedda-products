<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_images', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('image');
            $table->boolean('featured')->default(false);
            
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');
            
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
        Schema::dropIfExists('client_images');
    }
}
