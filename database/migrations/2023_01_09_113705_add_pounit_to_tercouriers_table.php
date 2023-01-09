<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPounitToTercouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tercouriers', function (Blueprint $table) {
            $table->string('po_id')->after('docket_no')->nullable();
            $table->string('basic_amount')->after('po_id')->nullable();
            $table->string('total_amount')->after('basic_amount')->nullable();
            $table->string('invoice_no')->after('total_amount')->nullable();
            $table->string('invoice_date')->after('invoice_no')->nullable();
            $table->string('ter_type')->after('invoice_date')->comment('1=>invoice 2=>courier')->nullable();
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
