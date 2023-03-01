<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMailTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_mail_trackers', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('ter_month')->nullable();
            $table->string('saved_last_date')->nullable();
            $table->string('last_mail_date')->nullable();
            $table->string('mail_date')->nullable();
            $table->string('mail_number')->nullable();
            $table->string('ter_received')->default(0)->comment("0=>No 1=>Yes");
            $table->string('mail_sent')->default(0)->comment("0=>No 1=>Yes");
            $table->string('ter_reject')->default(0)->comment("0=>No 1=>Yes");
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
        Schema::dropIfExists('employee_mail_trackers');
    }
}
