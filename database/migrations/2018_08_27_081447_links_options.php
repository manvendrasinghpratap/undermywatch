<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinksOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('link_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id')->unsigned()->nullable();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->string('setting_name')->nullable();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('link_options');
    }
}
