<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandoverDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handover_details', function (Blueprint $table) {
            $table->id();
            $table->string('handover_id')->nullable();
            $table->string('ter_id_count')->nullable();
            $table->string('ter_ids')->nullable();
            $table->string('department')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('handover_remarks')->nullable();
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
        Schema::dropIfExists('handover_details');
    }
}
