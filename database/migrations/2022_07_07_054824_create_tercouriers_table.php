<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTercouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tercouriers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date_of_receipt')->nullable();
            $table->string('docket_no')->nullable();
            $table->string('docket_date')->nullable();
            $table->string('courier_id')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('location')->nullable();
            $table->string('company_name')->nullable();
            $table->string('terfrom_date')->nullable();
            $table->string('terto_date')->nullable();
            $table->string('details')->nullable();
            $table->string('amount')->nullable();
            $table->string('delivery_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('given_to')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('tercouriers');
    }
}
