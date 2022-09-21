<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFourColumnsToSenderDetailsTable extends Migration
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
            $table->string('beneficiary_name')->after('address_pin_code')->nullable();
            $table->string('account_base_type')->after('branch_name')->nullable();
            $table->string('transfer_type')->after('account_base_type')->nullable();
            $table->string('account_type')->after('transfer_type')->nullable();
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
