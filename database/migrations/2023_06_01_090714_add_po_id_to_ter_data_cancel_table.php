<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoIdToTerDataCancelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ter_data_cancel', function (Blueprint $table) {
            //
            $table->string('po_id')->after('updated_id')->nullable();
            $table->string('amount_adjusted')->after('po_id')->nullable();
            $table->string('updated_po_amount')->after('amount_adjusted')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ter_data_cancel', function (Blueprint $table) {
            //
        });
    }
}
