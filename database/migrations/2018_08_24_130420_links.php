<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Links extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('createdby_id')->unsigned()->nullable();
            $table->foreign('createdby_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->integer('domain_id')->unsigned()->nullable();
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('set null');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('safe_link', 512)->nullable();
            $table->string('money_link', 512)->nullable();
            $table->string('landingpage')->nullable();
            $table->integer('clicks')->unsigned()->default(0);
            $table->integer('click_limit')->unsigned()->default(0);
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
        Schema::dropIfExists('links');
    }
}
