<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentToFinfectDateToTerDeductionSettlementsTable extends Migration
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
            $table->string('sent_to_finfect_date')->after('book_date')->nullable();
            $table->string('paid_date')->after('sent_to_finfect_date')->nullable();
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
