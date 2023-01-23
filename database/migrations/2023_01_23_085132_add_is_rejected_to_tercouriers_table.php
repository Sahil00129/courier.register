<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRejectedToTercouriersTable extends Migration
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
            $table->string('is_rejected')->default(0)->comment("0=>No 1=>Yes")->after('txn_type');

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
