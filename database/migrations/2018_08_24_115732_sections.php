<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('createdby_id')->unsigned()->nullable();
            $table->foreign('createdby_id')->references('id')->on('users')->onDelete('set null');
            $table->string('slug')->unique();
            $table->string('name')->default("")->nullable();
            $table->text('features')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
