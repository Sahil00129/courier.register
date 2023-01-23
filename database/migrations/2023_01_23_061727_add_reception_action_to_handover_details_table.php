<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceptionActionToHandoverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('handover_details', function (Blueprint $table) {
            //
            $table->string('reception_action')->default(0)->comment("0=>No 1=>Yes")->after('is_received');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('handover_details', function (Blueprint $table) {
            //
        });
    }
}
