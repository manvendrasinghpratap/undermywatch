<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('blacklist_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_permanent')->default(false);
            $table->double('start')->unsigned()->nullable();
            $table->double('end')->unsigned()->nullable();
            $table->integer('repetition')->default(0);
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
        Schema::dropIfExists('blacklist_ips');
    }
}
