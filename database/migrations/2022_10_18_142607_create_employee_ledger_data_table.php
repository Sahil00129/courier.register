<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLedgerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_ledger_data', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('wallet_id')->nullable();
            $table->string('ter_id')->nullable();
            $table->string('ter_expense')->nullable();
            $table->string('incoming_payment')->nullable();
            $table->string('ledger_balance')->nullable();
            $table->string('utilize_amount')->nullable();
            $table->string('action_done')->nullable();
            $table->string('ax_voucher_number')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('updated_date')->nullable();
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
        Schema::dropIfExists('employee_ledger_data');
    }
}
