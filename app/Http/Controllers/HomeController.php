<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $count_unprocessed_ter=DB::table('tercouriers')->select('id')->where('status',2)->count();
        // $today_tercourier_handover_count = DB::table('tercouriers')->select('id')->where('status',2)->where('created_at','=',date("Y-m-d"))->count();
        $data= DB::table('tercouriers')->select('id','updated_at')->where('status',2)->get();
        $size=sizeof($data);
        // $val="";
         $count=0;
        for($i=0;$i<$size;$i++)
        {
            $val= explode(" ",$data[$i]->updated_at);
            $date1=$val[0];
            // $id=$data[$i]->id;
               if($date1 == date("Y-m-d"))
               {
                $count++;
               }
        }
     $today_received_ter_count = $count;

     $data_processed= DB::table('tercouriers')->select('id','updated_at')->where('status',3)->get();
     $size_processed=sizeof($data_processed);
     // $val="";
      $count_processed=0;
     for($i=0;$i<$size_processed;$i++)
     {
         $val= explode(" ",$data_processed[$i]->updated_at);
         $date_processed=$val[0];
         // $id=$data[$i]->id;
            if($date_processed == date("Y-m-d"))
            {
             $count_processed++;
            }
     }


     $today_processed_ter_count = $count_processed;

    //  Today Paid TER left 
    
        return view('pages.dashboard',['unprocessed_ter'=>$count_unprocessed_ter,'received_ter'=>$today_received_ter_count,'processed_ter'=>$today_processed_ter_count]);
    }
}
