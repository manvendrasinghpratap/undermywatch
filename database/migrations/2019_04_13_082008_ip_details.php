<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IpDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blacklist_ips', function (Blueprint $table) {
            $table->text('isp')->nullable()->after('repetition');
            $table->text('organization')->nullable()->after('isp');
        });
        Schema::table('blacklist_ipsv6', function (Blueprint $table) {
            $table->text('isp')->nullable()->after('repetition');
            $table->text('organization')->nullable()->after('isp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blacklist_ips', function (Blueprint $table) {
            $table->dropColumn('isp');
            $table->dropColumn('organization');
        });
        Schema::table('blacklist_ipsv6', function (Blueprint $table) {
            $table->dropColumn('isp');
            $table->dropColumn('organization');
        });
    }
}
