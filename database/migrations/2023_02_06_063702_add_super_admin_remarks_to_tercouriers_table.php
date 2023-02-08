<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuperAdminRemarksToTercouriersTable extends Migration
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
            $table->string('super_admin_remarks')->after('hr_admin_remark')->nullable();
            $table->string('cancel_reject')->default(0)->comment("0=>No 1=>Yes")->after('hr_admin_remark');
            // $table->string('accept_cancel_reject')->default(0)->comment("0=>No 1=>Yes")->after('cancel_reject');

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
