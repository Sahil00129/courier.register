<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaveLoginDeatailsTercouriersTable extends Migration
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
            $table->string('saved_by_id')->after('voucher_code')->nullable();
            $table->string('saved_by_name')->after('saved_by_id')->nullable();
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
