<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TerCancelData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ter_data_cancel', function (Blueprint $table) {
            $table->id();
            $table->string('updated_id')->nullable();
            $table->string('remarks')->nullable();
            $table->string('updated_date')->nullable();
            $table->string('updated_by_user_id')->nullable();
            $table->string('updated_by_user_name')->nullable();
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
        //
    }
}
