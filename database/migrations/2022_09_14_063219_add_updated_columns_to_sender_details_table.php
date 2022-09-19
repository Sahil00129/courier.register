<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedColumnsToSenderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sender_details', function (Blueprint $table) {
            //
            $table->string('grade')->after('employee_id')->nullable();
            $table->string('designation')->after('name')->nullable();
            $table->string('hq_state')->after('location')->nullable();
            $table->string('territory')->after('hq_state')->nullable();
            $table->string('team')->after('territory')->nullable();
            $table->string('date_of_joining')->after('telephone_no')->nullable();
            $table->string('category')->after('last_working_date')->nullable();
            $table->string('date_of_birth')->after('category')->nullable();
            $table->string('education_qualification')->after('date_of_birth')->nullable();
            $table->string('gender')->after('education_qualification')->nullable();
            $table->string('marital_status')->after('gender')->nullable();
            $table->string('official_email_id')->after('marital_status')->nullable();
            $table->string('personal_email_id')->after('official_email_id')->nullable();
            $table->string('uan_number')->after('personal_email_id')->nullable();
            $table->string('esic_status')->after('uan_number')->nullable();
            $table->string('esic_no')->after('esic_status')->nullable();
            $table->string('compliance_branch')->after('esic_no')->nullable();
            $table->string('department')->after('compliance_branch')->nullable();
            $table->string('pan')->after('department')->nullable();
            $table->string('aadhar_number')->after('pan')->nullable();
            $table->string('account_number')->after('aadhar_number')->nullable();
            $table->string('ifsc')->after('account_number')->nullable();
            $table->string('bank_name')->after('ifsc')->nullable();
            $table->string('branch_name')->after('bank_name')->nullable();
            $table->string('address_1')->after('account_number')->nullable();
            $table->string('address_2')->after('address_1')->nullable();
            $table->string('address_3')->after('address_2')->nullable();
            $table->string('address_district')->after('address_3')->nullable();
            $table->string('address_state')->after('address_district')->nullable();
            $table->string('address_pin_code')->after('address_state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sender_details', function (Blueprint $table) {
            //
        });
    }
}
