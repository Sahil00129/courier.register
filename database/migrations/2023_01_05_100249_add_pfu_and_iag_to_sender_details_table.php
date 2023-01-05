<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPfuAndIagToSenderDetailsTable extends Migration
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
            $table->string('iag_code')->after('ax_id')->nullable();
            $table->string('pfu')->after('iag_code')->nullable();
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
