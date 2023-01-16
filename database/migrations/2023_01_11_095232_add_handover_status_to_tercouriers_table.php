 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHandoverStatusToTercouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tercouriers', function (Blueprint $table) {
            //
            Schema::table('tercouriers', function (Blueprint $table) {
                $table->string('handover_id')->after('file_name')->nullable();
            //    $table->string('copy_status')->default(0)->comment("1=>Handover_Created 2=>Accepted 3=>Rejected")->after('status');
            $table->string('copy_status')->after('status')->nullable();
            // $table->string('copy_status')->nullable();


              });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tercouriers', function (Blueprint $table) {
            //
        });
    }
}
