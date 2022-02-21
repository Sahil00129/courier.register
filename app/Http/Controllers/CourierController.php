<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Sender;
use Response;

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
        $couriers = DB::table('new_courier_created')->get();
        //echo'<pre>'; print_r($couriers); die;
        return view('pages.courier-table',['couriers' => $couriers]);

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
     //echo"<pre>"; print_r($_POST); die;
     try
     {
       $name_company = $request->name_company; 
       $location = $request->location;
       $docket_no = $request->docket_no;
       $docket_date = $request->docket_date;
       $telephone_no = $request->telephone_no;
       $customer = $request->customer_type;
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
           
        
         //echo'<pre>'; print_r($request->catagories); die;
            $sender = ([
                  'name_company' => $name_company,
                  'location' => $location,
                  'docket_no' => $docket_no,
                  'docket_date' => $docket_date,
                  'customer_type' => $customer,
                  'telephone_no' => $telephone_no,
                  'courier_name' => $courier_name,
                  'catagories' => $value,
                  'for' => $request->for[$key],
                  'distributor_agreement' => @$request->distributor_agreement[$key],
                  'distributor_name' => $request->distributor_name[$key],
                  'document_type' => $request->document_type[$key],
                  'distributor_location' => $request->distributor_location[$key],
                  'security_check' => $request->security_check[$key],
                  'documents' => $request->documents[$key],
                  'ledger_for' => @$request->ledger_for[$key],
                  'type_ledger' => $request->type_ledger[$key],
                  'party_name' => $request->party_name[$key],
                  'year_l' => $request->year_l[$key],
                  'invoice_type' => @$request->invoice_type[$key],
                  'invoice_number' => $request->invoice_number[$key],
                  'amount_invoice' => $request->amount_invoice[$key],
                  'party_name_invoices' => $request->party_name_invoices[$key],
                  'month_invoices' => $request->month_invoices[$key],
                  'discription_i' => $request->discription_i[$key],
                  'bills_type' => @$request->bills_type[$key],
                  'invoice_number_bills' => $request->invoice_number_bills[$key],
                  'amount_bills' => $request->amount_bills[$key],
                  'previouse_reading_b' => $request->previouse_reading_b[$key],
                  'current_reading_b' => $request->current_reading_b[$key],
                  'for_month_b' => $request->for_month_b[$key],
                  'bank_name' => $request->bank_name[$key],
                  'document_type_cheques' => $request->document_type_cheques[$key],
                  'acc_number' => $request->acc_number[$key],
                  'for_month_cheques' => $request->for_month_cheques[$key],
                  'series' => $request->series[$key],
                  'statement_no' => $request->statement_no[$key],
                  'amount_imperest' => @$request->amount_imperest[$key],
                  'for_month_imprest' => @$request->for_month_imprest[$key],
                  'discription_legal' => $request->discription_legal[$key],
                  'company_name_legal' => $request->company_name_legal[$key],
                  'person_name_legal' => $request->person_name_legal[$key],
                  'number_of_pc' => $request->number_of_pc[$key],
                  'discription_pc' => $request->discription_pc[$key],
                  'company_name_pc' => $request->company_name_pc[$key],
                  'document_number_govt' => $request->document_number_govt[$key],
                  'Discription_govt' => $request->Discription_govt[$key],
                  'DDR_type' => @$request->DDR_type[$key],
                  'number_of_DDR' => @$request->number_of_DDR[$key],
                  'party_name_ddr' => @$request->party_name_ddr[$key],
                  'physical_stock_report' => @$request->physical_stock_report[$key],
                  'discription_physical' => @$request->discription_physical[$key],
                  'month_physical' => @$request->month_physical[$key],
                  'discription_affidavits' => @$request->discription_affidavits[$key],
                  'company_name_affidavits' => @$request->company_name_affidavits[$key],
                  'discription_it' => @$request->discription_it[$key],
                   ]);
                // echo'<pre>'; print_r($sender); die;
                // $sender->save();
                //echo'<pre>'; print_r($sender); die;
                DB::table('new_courier_created')->insert($sender);
              }
                $response['success'] = true;
                $response['messages'] = 'Succesfully Submitted';
                return Response::json($response); 
            }catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong';
               // echo'<pre>'; print_r($e); die;
                return Response::json($e);
              }
          }  


}
