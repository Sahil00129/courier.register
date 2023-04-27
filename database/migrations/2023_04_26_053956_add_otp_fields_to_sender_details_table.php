<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpFieldsToSenderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sender_details', function (Blueprint $table) {
            //
            $table->string('otp')->after('status')->nullable();
            $table->timestamp('otp_sent_time')->after('otp')->nullable();
            $table->string('last_ip')->after('otp_sent_time')->nullable();
            $table->string('sms_api_response')->after('last_ip')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sender_details', function (Blueprint $table) {
            //
        });
    }
}
