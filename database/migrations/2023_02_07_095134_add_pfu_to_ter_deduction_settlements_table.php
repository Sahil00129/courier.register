<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPfuToTerDeductionSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ter_deduction_settlements', function (Blueprint $table) {
            //
            $table->string('pfu')->after('ax_code')->nullable();
            $table->string('iag_code')->after('pfu')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ter_deduction_settlements', function (Blueprint $table) {
            //
        });
    }
}
