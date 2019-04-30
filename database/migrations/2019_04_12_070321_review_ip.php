<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('blacklist_ips', function (Blueprint $table) {
            $table->boolean('isreviewed')->after('is_permanent')->default(1);
            $table->text('notes')->nullable()->after('is_permanent');
        });
        Schema::table('blacklist_ips', function (Blueprint $table) {
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
        //
        Schema::table('blacklist_ips', function (Blueprint $table) {
            $table->dropColumn('isreviewed');
            $table->dropColumn('notes');
        });
    }
}
