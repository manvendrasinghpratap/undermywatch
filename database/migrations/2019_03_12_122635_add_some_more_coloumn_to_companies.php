<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeMoreColoumnToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table("companies", function ($table) {
            $table->string('contact_person','110')->after('company_name')->nullable();
            $table->string('contact_no', 150)->after('company_name')->nullable();
            $table->text('company_address')->after('company_name')->nullable();
            $table->text('company_email')->after('company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('contact_person');
            $table->dropColumn('contact_no');
            $table->dropColumn('company_address');
            $table->dropColumn('company_email');
        });
    }
}
