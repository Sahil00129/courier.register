<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sender_details', function (Blueprint $table) {
            $table->id();
            $table->string('ax_id');
            $table->string('name')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('last_working_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('sender_details');
    }
}
