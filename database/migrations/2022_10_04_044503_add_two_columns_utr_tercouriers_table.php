<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoColumnsUtrTercouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tercouriers', function (Blueprint $table) {
            //
            $table->string('utr')->after('payment_type')->nullable();
            $table->string('sms_sent')->after('utr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tercouriers', function (Blueprint $table) {
            //
        });
    }
}
