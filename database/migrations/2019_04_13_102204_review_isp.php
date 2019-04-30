<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewIsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blacklist_isps', function (Blueprint $table) {
            $table->boolean('isreviewed')->default(1)->after('id');
            $table->boolean('isblocked')->default(1)->after('id');
            $table->string("popularity", "32")->nullable()->after('isp');
            $table->text("reason")->nullable()->after('isp');
            $table->text('notes')->nullable()->after('isp');
            $table->integer('addedby_id')->unsigned()->nullable()->after("isreviewed");
            $table->foreign('addedby_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('blacklist_isps', function (Blueprint $table) {
            $table->boolean('isreviewed')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blacklist_isps', function (Blueprint $table) {
            $table->dropColumn('isreviewed');
            $table->dropColumn('isblocked');
            $table->dropColumn('popularity');
            $table->dropColumn('reason');
            $table->dropColumn('notes');
            $table->dropColumn('addedby_id');
        });
    }
}
