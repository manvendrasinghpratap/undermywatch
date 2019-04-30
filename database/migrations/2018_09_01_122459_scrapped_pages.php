<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScrappedPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('scapped_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id')->unsigned()->nullable();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->longText('content')->nullable();
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
        //
        Schema::dropIfExists('scapped_data');
    }
}
