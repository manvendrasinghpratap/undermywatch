<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkUpdatedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('links', function (Blueprint $table) {
            $table->integer('updatedby_id')->unsigned()->nullable()->after('createdby_id');
            $table->foreign('updatedby_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::table('links', function (Blueprint $table) {
            $table->dropForeign('links_updatedby_id_foreign');
            $table->dropColumn('updatedby_id');
        });
    }
}
