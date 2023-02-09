<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeductionCheckToTercouriersTable extends Migration
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
            $table->string('dedcution_paid')->default(0)->comment("0=>No 1=>Yes")->after('status');

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
