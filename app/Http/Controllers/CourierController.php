<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Sender;

class CourierController extends Controller
{
    public function createCourier()
    {
        $couriers = DB::table('courier_companies')->select ('courier_name')->distinct()->get();
        $categorys = DB::table('catagories')->select ('catagories')->distinct()->get();
        $forcompany = DB::table('for_companies')->select ('for_company')->distinct()->get();
        return view('pages.create-courier',  ['couriers' => $couriers ,'categorys' => $categorys ,'forcompany' => $forcompany]);
    }

    public function courierTable()
    {
        return view('pages.courier-table');
    }
    
    
    public function autocompleteSearch(Request $request)
    { 
        if ($request->ajax()) {
           $data = Sender::orderby('name')->select('location','name','type','telephone_no')->where('name', 'like', '%' .$request->search . '%')->orWhere('location', 'like', '%' .$request->search . '%')->get();
               // $data = Sender::where('name','LIKE',$request->search.'%')->orWhere('location','LIKE',      $request->search.'%')->get();
              // echo'<pre>'; print_r($data); die;
              $output = '';
            if (count($data)>0) {
                   $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                   //echo'<pre>'; print_r($output); die;
                   foreach ($data as $row) {
                   //echo'<pre>'; print_r($row->name);die;
                    $output .= '<li class="list-group-item">'.$row->name.':'.$row->location.':'.$row->telephone_no.':'.$row->type.'</li>';  
                }
                   $output .= '</ul>';
               }else {
                  $output .= '<li class="list-group-item disabled">'.'No Data Found'.'</li> <a href="'.url('add-sender').'" class="btn btn-sm btn-primary" >Add Sender</a>'
                ;
            }
            return $output;
        }
        return view('pages.create-courier');  
    }

    public function newCourier(Request $request)
    {
     echo"<pre>"; print_r($_POST); die;

       $name_company = $request->name_company; 
       $location = $request->location;
       $docket_no = $request->docket_no;
       $docket_date = $request->docket_date;
       $telephone_no = $request->telephone_no;
       $courier_name = $request->slct;
       if( $request->slct == 'other'){
           $courier_name = $request->other_courier;
           $cmpny = new CourierCompany;
           $cmpny->courier_name = $request->other_courier;
           $cmpny->save();
       }else{
           $courier_name = $request->slct;
       }

       foreach($request->catagories as $key => $value){
           
             if(@$request->for[$key] == 'other'){
             $c = $request->cfor[$key];
             $cfor = new ForCompany;
             $cfor->for_company = $request->cfor[$key];
             $cfor->save();
             }else{
             @$c = $request->for[$key];
       } 
      //echo'<pre>'; print_r($c); die;
            $sender = ([
                  'name_company' => $name_company,
                  'location' => $location,
                  'docket_no' => $docket_no,
                  'docket_date' => $docket_date,
                  'telephone_no' => $telephone_no,
                  'courier_name' => $courier_name,
                  'catagories' => $value,
                  'for' => @$c,
                  'bill' => $request->bill[$key],
                  'amount' => $request->amount[$key],
                  'from' => $request->from[$key],
                  'month' => $request->month[$key],
                  'financial' => $request->financial[$key],
                  'kyc' => $request->kyc[$key],
                  'other_catagory' => $request->other_catagory[$key],
                   ]);
                // echo'<pre>'; print_r($sender); die;
                // $sender->save();
                //echo'<pre>'; print_r($sender); die;
                DB::table('new_courier_sender')->insert($sender);
              }
                $response['success'] = true;
                $response['messages'] = 'Succesfully Submitted';
                return Response::json($response); 
          }  


}
