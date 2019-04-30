<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('addedby_id')->unsigned()->nullable();
            $table->foreign('addedby_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean('enable_log')->default(false);
            $table->string('domain')->unique();
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
        Schema::dropIfExists('domains');
    }
}
