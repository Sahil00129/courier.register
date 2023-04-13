<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToPosTable extends Migration
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
            $table->string('total_tax_amount')->after('po_value')->nullable();
            $table->string('gst_rate')->after('total_tax_amount')->nullable();
            $table->string('gst_amount')->after('gst_rate')->nullable();
            $table->string('source_po_num')->after('gst_amount')->nullable();
            $table->string('erp_num')->after('source_po_num')->nullable();
            $table->string('state')->after('erp_num')->nullable();
            $table->string('crop')->after('state')->nullable();
            $table->string('amm_agm')->after('crop')->nullable();
            $table->string('po_date')->after('amm_agm')->nullable();
            $table->string('product')->after('po_date')->nullable();


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
