<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerDeductionSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ter_deduction_settlements', function (Blueprint $table) {
            $table->id();

            $table->string('parent_ter_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('ax_code')->nullable();
            $table->string('terfrom_date')->nullable();
            $table->string('terto_date')->nullable();
            $table->string('actual_amount')->nullable();
            $table->string('prev_payable_sum')->nullable();
            $table->string('payable_amount')->nullable();
            $table->string('voucher_code')->nullable();
            $table->string('book_date')->nullable();
            $table->string('payment_type')->nullable();
            $table->tinyInteger('status')->default(7);
            $table->text('remarks')->nullable();
            $table->string('utr')->nullable();
            $table->string('file_name')->nullable();
            $table->string('reference_transaction_id')->nullable();
            $table->string('finfect_response')->nullable();
            $table->string('saved_by_id')->nullable();
            $table->string('saved_by_name')->nullable();
            $table->string('updated_by_id')->nullable();
            $table->string('updated_by_name')->nullable();
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
        Schema::dropIfExists('ter_deduction_settlements');
    }
}
