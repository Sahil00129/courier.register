<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeBalanceTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('employee_balance', function (Blueprint $table) {
            $table->id();
            $table->string('current_balance')->nullable();
            $table->string('advance_amount')->nullable();
            $table->string('ter_id')->nullable();
            $table->string('utilize_amount')->nullable();
            $table->string('action_done')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->timestamps();
            //
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
