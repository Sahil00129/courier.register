<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceHandoverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_handover_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_handover_id')->nullable();
            $table->string('invoice_id_count')->nullable();
            $table->string('unids')->nullable();
            $table->string('handover_by_department')->nullable();
            $table->string('handover_to_department')->nullable();
            $table->string('handover_date')->nullable();
            $table->string('acc_handover_date')->nullable();
            $table->string('acc_accept_reject_date')->nullable();
            $table->string('scan_accept_reject_date')->nullable();
            $table->string('handover_remarks')->nullable();
            $table->string('user_action')->nullable();
            $table->string('action_done')->default(0)->comment("0=>No 1=>Yes");
            $table->string('is_received')->default(0)->comment("0=>No 1=>Yes");
            $table->string('created_user_id')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_handover_details');
    }
}
