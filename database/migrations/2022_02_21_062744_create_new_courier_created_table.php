<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCourierCreatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_courier_created', function (Blueprint $table) {
            $table->id();
            $table->string('name_company')->nullable();
            $table->string('location')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('docket_no')->nullable();
            $table->string('docket_date')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('catagories')->nullable();
            $table->string('for')->nullable();
            $table->string('distributor_agreement')->nullable();
            $table->string('distributor_name')->nullable();
            $table->string('document_type')->nullable();
            $table->string('distributor_location')->nullable();
            $table->string('security_check')->nullable();
            $table->string('documents')->nullable();
            $table->string('ledger_for')->nullable();
            $table->string('type_ledger')->nullable();
            $table->string('party_name')->nullable();
            $table->string('year_l')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('amount_invoice')->nullable();
            $table->string('party_name_invoices')->nullable();
            $table->string('month_invoices')->nullable();
            $table->string('discription_i')->nullable();
            $table->string('bills_type')->nullable();
            $table->string('invoice_number_bills')->nullable();
            $table->string('amount_bills')->nullable();
            $table->string('previouse_reading_b')->nullable();
            $table->string('current_reading_b')->nullable();
            $table->string('for_month_b')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('document_type_cheques')->nullable();
            $table->string('acc_number')->nullable();
            $table->string('for_month_cheques')->nullable();
            $table->string('series')->nullable();
            $table->string('statement_no')->nullable();
            $table->string('amount_imperest')->nullable();
            $table->string('for_month_imprest')->nullable();
            $table->string('discription_legal')->nullable();
            $table->string('company_name_legal')->nullable();
            $table->string('person_name_legal')->nullable();
            $table->string('number_of_pc')->nullable();
            $table->string('discription_pc')->nullable();
            $table->string('company_name_pc')->nullable();
            $table->string('document_number_govt')->nullable();
            $table->string('Discription_govt')->nullable();
            $table->string('DDR_type')->nullable();
            $table->string('number_of_DDR')->nullable();
            $table->string('party_name_ddr')->nullable();
            $table->string('physical_stock_report')->nullable();
            $table->string('discription_physical')->nullable();
            $table->string('month_physical')->nullable();
            $table->string('discription_affidavits')->nullable();
            $table->string('company_name_affidavits')->nullable();
            $table->string('discription_it')->nullable();  
            $table->string('given_to')->nullable();
            $table->string('checked_by')->nullable();        
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
        Schema::dropIfExists('new_courier_created');
    }
}
