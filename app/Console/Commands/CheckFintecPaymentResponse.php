<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CheckFintecPaymentResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paymentresponse:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to get the response from finfect';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data=DB::table('tercouriers')->where('id',1)->get()->toArray();
        echo "<pre>";
        print_r($data);
       echo "My First Job Scheduler";
    }
}
