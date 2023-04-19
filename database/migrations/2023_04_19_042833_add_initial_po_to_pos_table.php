<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInitialPoToPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos', function (Blueprint $table) {
            //
            $table->string('initial_po_value')->after('po_value')->nullable();
            $table->string('cancel_po_remarks')->after('initial_po_value')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos', function (Blueprint $table) {
            //
        });
    }
}
