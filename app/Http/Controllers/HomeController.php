<?php

namespace App\Http\Controllers;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // ===================widget 1
        $current_day_handover_ter_count = DB::table('tercouriers')->select('id')->where('status', 2)->whereDate('updated_at', date("Y-m-d"))->count();

        $current_day_handover_ter_sum = DB::table('tercouriers')->where('status', 2)->whereDate('updated_at', date("Y-m-d"))->sum('amount');

        $current_month_handover_ter_count = DB::table('tercouriers')->select('id')->where('status', 2)->whereMonth('updated_at', date("m"))->count();
        $current_month_handover_ter_sum = DB::table('tercouriers')->where('status', 2)->whereMonth('updated_at', date("m"))->sum('amount');
        // return $current_month_handover_ter_sum;

        // ===========================widget 2
        $current_day_sent_to_finfect_ter_count = DB::table('tercouriers')->select('id')->where('status', 3)->whereDate('updated_at', date("Y-m-d"))->count();
        // echo $current_day_sent_to_finfect_ter_count ; die;
        $current_day_sent_to_finfect_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->where('status', 3)->whereDate('updated_at', date("Y-m-d"))->get();

        $current_day_sent_to_finfect_ter_sum = self::totalSum($data_sent_to_finfect);

        /////////////////////Current Month Processed//////////////////////////
        $current_month_sent_to_finfect_ter_count = DB::table('tercouriers')->select('id')->where('status', 3)->whereMonth('updated_at', date("m"))->count();
        // echo $current_day_sent_to_finfect_ter_count ; die;
        $current_month_sent_to_finfect_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->where('status', 3)->whereMonth('updated_at', date("m"))->get();

        $current_month_sent_to_finfect_ter_sum = self::totalSum($data_sent_to_finfect);

        // widget 3 =================
        $current_day_paid_ter_count = DB::table('tercouriers')->select('id')->where('status', 5)->whereDate('updated_at', date("Y-m-d"))->count();

        $current_day_paid_ter_sum = DB::table('tercouriers')->where('status', 5)->whereDate('updated_at', date("Y-m-d"))->sum('amount');
        //////====== Current Month Paid Ter
        $current_month_paid_ter_count = DB::table('tercouriers')->select('id')->where('status', 5)->whereMonth('updated_at', date("m"))->count();

        $current_month_paid_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->where('status', 5)->whereMonth('updated_at', date("m"))->get();

        $current_month_paid_ter_sum = self::totalSum($data_sent_to_finfect);

        return view('pages.dashboard', ['current_day_handover_ter_count' => $current_day_handover_ter_count, 'current_day_handover_ter_sum' => $current_day_handover_ter_sum,
            'current_month_handover_ter_count' => $current_month_handover_ter_count, 'current_month_handover_ter_sum' => $current_month_handover_ter_sum,
            'current_day_sent_to_finfect_ter_count' => $current_day_sent_to_finfect_ter_count,
            'current_day_sent_to_finfect_ter_sum' => $current_day_sent_to_finfect_ter_sum, 'current_month_sent_to_finfect_ter_count' => $current_month_sent_to_finfect_ter_count, 'current_month_sent_to_finfect_ter_sum' => $current_month_sent_to_finfect_ter_sum, 'current_day_paid_ter_count' => $current_day_paid_ter_count,
            'current_day_paid_ter_sum' => $current_day_paid_ter_sum,
            'current_month_paid_ter_count' => $current_month_paid_ter_count,
            'current_month_paid_ter_sum' => $current_month_paid_ter_sum]);

    }

    public function totalSum($data)
    {

        $sum1 = 0;
        $sum2 = array();

        $decode1 = json_decode($data);
        $decode2 = array();
        for ($i = 0; $i < sizeof($decode1); $i++) {
            $decode2[$i] = json_decode($decode1[$i]->payable_amount);

        }

        for ($j = 0, $n = 0; $j < sizeof($decode2); $j++) {

            if (sizeof($decode2[$j]) > 1) {
                $sum1 = array_sum($decode2[$j]);
            } else {
                $sum2[$n] = $decode2[$j][0];
                $n++;

            }
        }
        $current_month_sent_to_finfect_ter_sum = $sum1 + array_sum($sum2);
        return $current_month_sent_to_finfect_ter_sum;
    }
}
