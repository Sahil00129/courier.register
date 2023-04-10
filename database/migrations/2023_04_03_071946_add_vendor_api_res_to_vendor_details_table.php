<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorApiResToVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            //
            $table->string('api_sent_data')->after('erp_code')->nullable();
            $table->string('api_response')->after('api_sent_data')->nullable();
            $table->string('saved_on_finfect')->default(0)->comment("1=>Yes 0=>No")->after('api_sent_data');
            $table->string('data_id')->after('saved_on_finfect')->nullable();
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            //
        });
    }
}
