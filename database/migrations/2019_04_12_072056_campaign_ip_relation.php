<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CampaignIpRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_campaign_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id')->unsigned()->nullable();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->integer('ip_id')->unsigned()->nullable();
            $table->foreign('ip_id')->references('id')->on('blacklist_ips')->onDelete('cascade');
            $table->integer('clicks')->default(0);
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
        Schema::dropIfExists('ip_campaign_relation');
    }
}
