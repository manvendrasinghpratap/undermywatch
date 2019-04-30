<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ipsv6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('blacklist_ipsv6', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_permanent')->default(false);
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('blacklist_ipsv6');
    }
}
