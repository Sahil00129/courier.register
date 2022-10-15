<?php

namespace App\Http\Controllers;

use App\Models\Tercourier;
use Carbon\Carbon;
use DB;
use Response;

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

        $current_month_handover_ter_count = DB::table('tercouriers')->select('id')->where('status', 2)->whereMonth('updated_at', date("m"))->whereYear('updated_at', date("Y"))->count();
        $current_month_handover_ter_sum = DB::table('tercouriers')->where('status', 2)->whereMonth('updated_at', date("m"))->whereYear('updated_at', date("Y"))->sum('amount');
        // return $current_month_handover_ter_sum;

        // ===========================widget 2
        $current_day_sent_to_finfect_ter_count = DB::table('tercouriers')->select('id')->whereIn('status', ['3', '5'])->whereDate('sent_to_finfect_date', date("Y-m-d"))->count();
        // echo $current_day_sent_to_finfect_ter_count ; die;
        $current_day_sent_to_finfect_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->whereIn('status', ['3', '5'])->whereDate('sent_to_finfect_date', date("Y-m-d"))->get();
        // echo"<pre>";
        if (sizeof($data_sent_to_finfect) > 0) {
            $current_day_sent_to_finfect_ter_sum = self::totalSum($data_sent_to_finfect);
        } else {
            $current_day_sent_to_finfect_ter_sum = 0;
        }

        /////////////////////Current Month Processed//////////////////////////
        $current_month_sent_to_finfect_ter_count = DB::table('tercouriers')->select('id')->whereIn('status', ['3', '5'])->whereMonth('sent_to_finfect_date', date("m"))->whereYear('sent_to_finfect_date', date("Y"))->count();
        // echo $current_day_sent_to_finfect_ter_count ; die;
        $current_month_sent_to_finfect_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->whereIn('status', ['3', '5'])->whereMonth('sent_to_finfect_date', date("m"))->whereYear('sent_to_finfect_date', date("Y"))->get();
        // echo"<pre>";
        // print_r($data_sent_to_finfect);
        if (sizeof($data_sent_to_finfect) > 0) {
            $current_month_sent_to_finfect_ter_sum = self::totalSum($data_sent_to_finfect);
            // print_r("Ds");
        } else {
            $current_month_sent_to_finfect_ter_sum = 0;
        }

        // widget 3 =================
        $current_day_paid_ter_count = DB::table('tercouriers')->select('id')->where('status', 5)->whereDate('updated_at', date("Y-m-d"))->count();

        $current_day_paid_ter_sum = DB::table('tercouriers')->where('status', 5)->whereDate('updated_at', date("Y-m-d"))->sum('amount');
        //////====== Current Month Paid Ter
        $current_month_paid_ter_count = DB::table('tercouriers')->select('id')->where('status', 5)->whereMonth('updated_at', date("m"))->whereYear('updated_at', date("Y"))->count();

        $current_month_paid_ter_sum = 0;
        $sum1 = 0;
        $sum2 = array();
        $data_sent_to_finfect = DB::table('tercouriers')->select('payable_amount')->where('status', 5)->whereMonth('updated_at', date("m"))->whereYear('updated_at', date("Y"))->get();
        // echo"<pre>";
        // print_r($data_sent_to_finfect);
        if (sizeof($data_sent_to_finfect) > 0) {
            $current_month_paid_ter_sum = self::totalSum($data_sent_to_finfect);
        } else {
            $current_month_paid_ter_sum = 0;
        }

        // =============== User Percentage ===============
        $total_ter = Tercourier::select('id')->whereIn('status', [3, 5])->whereMonth('sent_to_finfect_date', date("m"))->whereYear('sent_to_finfect_date', date("Y"))->count();
        //  echo $total_ter; die;

        $user_array = array(
            array("id" => 7, "name" => 'Vipin'),
            array("id" => 9, "name" => 'Veena'),
            array("id" => 10, "name" => 'Harpreet'),
            array("id" => 11, "name" => 'Rameshwer'),
        );

        foreach ($user_array as $key => $user) {

            $user1_ter = Tercourier::select('id')->whereIn('status', [3, 5])->where('updated_by_id', $user['id'])->whereMonth('sent_to_finfect_date', date("m"))->whereYear('sent_to_finfect_date', date("Y"))->count();
            $percentage[$user['name']][] = ($user1_ter / $total_ter) * 100;

        }
   
        return view('pages.dashboard', ['current_day_handover_ter_count' => $current_day_handover_ter_count, 'current_day_handover_ter_sum' => $current_day_handover_ter_sum,
            'current_month_handover_ter_count' => $current_month_handover_ter_count, 'current_month_handover_ter_sum' => $current_month_handover_ter_sum,
            'current_day_sent_to_finfect_ter_count' => $current_day_sent_to_finfect_ter_count,
            'current_day_sent_to_finfect_ter_sum' => $current_day_sent_to_finfect_ter_sum, 'current_month_sent_to_finfect_ter_count' => $current_month_sent_to_finfect_ter_count, 'current_month_sent_to_finfect_ter_sum' => $current_month_sent_to_finfect_ter_sum, 'current_day_paid_ter_count' => $current_day_paid_ter_count,
            'current_day_paid_ter_sum' => $current_day_paid_ter_sum,
            'current_month_paid_ter_count' => $current_month_paid_ter_count,
            'current_month_paid_ter_sum' => $current_month_paid_ter_sum,
            'percentage' => $percentage]);

    }

    public function totalSum($data)
    {

        $sum1 = 0;
        $sum2 = array();
        $sum3 = 0;
        $decode1 = json_decode($data);
        $decode2 = array();
        for ($i = 0; $i < sizeof($decode1); $i++) {
            $decode2[$i] = json_decode($decode1[$i]->payable_amount);

        }
        // echo"<pre>";
        // print_r($decode2);

        for ($j = 0, $n = 0; $j < sizeof($decode2); $j++) {
            // print_r(sizeof($decode2[$j]));
            // print_r($decode2[$j]);
            // print_r() . "<br>";
            if (gettype($decode2[$j]) == "array") {
                if (!empty($decode2[$j])) {
                    if (sizeof($decode2[$j]) > 1) {
                        $sum1 = array_sum($decode2[$j]);
                    } else {
                        $sum2[$n] = $decode2[$j][0];
                        $n++;

                    }

                }
            } else {
                // echo"<pre>";
                $sum3 = $sum3 + (int) $decode1[$j]->payable_amount;
            }
        }
        $current_month_sent_to_finfect_ter_sum = $sum1 + array_sum($sum2) + $sum3;
        // $current_month_sent_to_finfect_ter_sum = $sum1 + array_sum($sum2);
        return $current_month_sent_to_finfect_ter_sum;
    }

    public function unprocessedTerWidgets()
    {
        $get_previous_month = date('m', strtotime('-1 months'));

        $current_ter_count = DB::table('tercouriers')->select('id')->where('status', 2)->whereMonth('updated_at', date("m"))->whereYear('updated_at', date("Y"))->count();

        $previous_ter_count = DB::table('tercouriers')->select('id')->where('status', 2)->whereMonth('updated_at', $get_previous_month)->whereYear('updated_at', date("Y"))->count();

        $old = DB::table('tercouriers')->select('id')->where('status', 2)->whereMonth('updated_at', '!=', $get_previous_month)->whereMonth('updated_at', '!=', date("m"))->whereYear('updated_at', date("Y"))->count();

        $response['current_month_ter_count'] = $current_ter_count;
        $response['previous_ter_count'] = $previous_ter_count;
        $response['old'] = $old;
        $response['success'] = true;
        $response['messages'] = 'load_data';

        return Response::json($response);
    }

    public function dailyworkPerformance()
    {
        $total_ter = Tercourier::select('id')->whereIn('status', [3, 5])->whereMonth('sent_to_finfect_date', date("m"))->whereYear('sent_to_finfect_date', date("Y"))->count();

        $user_array = array(
            array("id" => 7, "name" => 'Vipin'),
            array("id" => 9, "name" => 'Veena'),
            array("id" => 10, "name" => 'Harpreet'),
            array("id" => 11, "name" => 'Rameshwer'),
        );

        // ==========user 1 Vipin======
        $users = Tercourier::select('id', 'sent_to_finfect_date')
            ->where('updated_by_id', 7)
            ->whereMonth('sent_to_finfect_date', date("m"))
            ->whereYear('sent_to_finfect_date', date("Y"))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->sent_to_finfect_date)->format('d'); // grouping by months
            });
        $date = date('d');

        $usermcount = [];
        $userArr1 = [];

        foreach ($users as $key => $value) {
            $usermcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= $date; $i++) {
            if (!empty($usermcount[$i])) {
                $userArr1[$i] = $usermcount[$i];
            } else {
                $userArr1[$i] = 0;
            }
        }
        $user1 = implode(',', $userArr1);
        // echo'<pre>';print_r([$user1]); die;
        // =========================
        // ==========user 2 Veena======
        $users = Tercourier::select('id', 'sent_to_finfect_date')
            ->where('updated_by_id', 9)
            ->whereMonth('sent_to_finfect_date', date("m"))
            ->whereYear('sent_to_finfect_date', date("Y"))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->sent_to_finfect_date)->format('d'); // grouping by months
            });
        $date = date('d');

        $usermcount = [];
        $userArr2 = [];

        foreach ($users as $key => $value) {
            $usermcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= $date; $i++) {
            if (!empty($usermcount[$i])) {
                $userArr2[$i] = $usermcount[$i];
            } else {
                $userArr2[$i] = 0;
            }
        }
        $user2 = implode(',', $userArr2);

        // ==========user 3 Harpreet======
        $users = Tercourier::select('id', 'sent_to_finfect_date')
            ->where('updated_by_id', 10)
            ->whereMonth('sent_to_finfect_date', date("m"))
            ->whereYear('sent_to_finfect_date', date("Y"))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->sent_to_finfect_date)->format('d'); // grouping by months
            });
        $date = date('d');

        $usermcount = [];
        $userArr3 = [];

        foreach ($users as $key => $value) {
            $usermcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= $date; $i++) {
            if (!empty($usermcount[$i])) {
                $userArr3[$i] = $usermcount[$i];
            } else {
                $userArr3[$i] = 0;
            }
        }
        $user3 = implode(',', $userArr3);

        // ==========user 4 Rameshwer======
        $users = Tercourier::select('id', 'sent_to_finfect_date')
            ->where('updated_by_id', 11)
            ->whereMonth('sent_to_finfect_date', date("m"))
            ->whereYear('sent_to_finfect_date', date("Y"))
            ->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->sent_to_finfect_date)->format('d'); // grouping by months
            });
        $date = date('d');

        $usermcount = [];
        $userArr4 = [];

        foreach ($users as $key => $value) {
            $usermcount[(int) $key] = count($value);
        }

        for ($i = 1; $i <= $date; $i++) {
            if (!empty($usermcount[$i])) {
                $userArr4[$i] = $usermcount[$i];
            } else {
                $userArr4[$i] = 0;
            }
        }
        $user4 = implode(',', $userArr4);
        //////////////////////////
        $days = date('d');
        $month = date('n');
        $countdate = array();
        for ($day = 1; $day <= $days; $day++) {
            $countdate[] = $day . '(' . date('D', strtotime($month . '/' . $day)) . ')';
        }
        //    echo'<pre>'; print_r($sd);
        //     die;
        //
        // for ($i = 1; $i <= $date; $i++) {
        //     $countdate[] = $i;
        // }
        $countloop = implode(',', $countdate);
        // echo '<pre>';
        // print_r($countdate);die;

        $response['user1'] = $user1;
        $response['user2'] = $user2;
        $response['user3'] = $user3;
        $response['user4'] = $user4;
        $response['countloop'] = $countloop;
        $response['total_ter'] = $total_ter;
        $response['success'] = true;
        $response['messages'] = 'load_data';

        return Response::json($response);

    }
}
