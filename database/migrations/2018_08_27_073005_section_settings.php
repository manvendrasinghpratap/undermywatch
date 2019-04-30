<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SectionSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('section_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            // $table->boolean('enable')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('show_in_table')->default(false);
            $table->string('field')->nullable();
            $table->string('field_title')->nullable();
            $table->string('field_description')->nullable();
            $table->text('default')->nullable();
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
        Schema::dropIfExists('section_settings');
    }
}
