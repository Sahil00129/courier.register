<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Sender;
use App\Models\CreateCourier;
use App\Models\CourierCompany;
use App\Models\ForCompany;
use Response;
use Session;

class CourierController extends Controller
{
    public function createCourier()
    {
        $senders =  DB::table('sender_details')->get();
        //echo'<pre>'; print_r($sender); die;
        $couriers = DB::table('courier_companies')->select ('courier_name')->distinct()->get();
        $categorys = DB::table('catagories')->select ('catagories')->distinct()->get();
        $forcompany = DB::table('for_companies')->select ('for_company')->distinct()->get();
        return view('pages.create-courier',  ['senders'=>$senders, 'couriers' => $couriers ,'categorys' => $categorys ,'forcompany' => $forcompany]);
    }

    public function courierTable()
    {
        $couriers = DB::table('new_courier_created')->get();
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
                foreach ($data as $row) {
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
        // echo'<pre>'; print_r($_POST); die;
        $name_company = $request->name_company; 
        $location = $request->location;
        $docket_no = $request->docket_no;
        $docket_date = $request->docket_date;
        $telephone_no = $request->telephone_no;
        $customer = $request->customer_type;
        $courier_name = $request->slct;
        if( $request->slct == 'Other'){
            $courier_name = $request->other_courier;
            $cmpny = new CourierCompany;
            $cmpny->courier_name = $request->other_courier;
            $cmpny->save();
        }else{
            $courier_name = $request->slct;
        }
        foreach($request->catagories as $key => $value){
            $dt = $request->document_type;
            if(!empty($dt)){
                $new = implode(' , ', $dt);
            }
            if(@$request->for[$key] == 'Other'){
                $c = $request->other_receiving[$key];
                $cfor = new ForCompany;
                $cfor->for_company = $request->other_receiving[$key];
                $cfor->save();
            }else{
                @$c = $request->for[$key];
            }
            $sender = ([
                'name_company' => $name_company,
                'location' => $location,
                'docket_no' => $docket_no,
                'docket_date' => $docket_date,
                'customer_type' => $customer,
                'telephone_no' => $telephone_no,
                'courier_name' => $courier_name,
                'catagories' => $value,
                'for' => @$c,
                'distributor_agreement' => @$request->distributor_agreement[$key],
                'distributor_name' => $request->distributor_name[$key],
                'document_type' => @$new,
                'distributor_location' => $request->distributor_location[$key],
                'remarks_distributor' => $request->remarks_distributor[$key],
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
                'amount_imperest' => $request->amount_imperest[$key],
                'for_month_imprest' => $request->for_month_imprest[$key],
                'discription_legal' => $request->discription_legal[$key],
                'company_name_legal' => $request->company_name_legal[$key],
                'person_name_legal' => $request->person_name_legal[$key],
                'number_of_pc' => $request->number_of_pc[$key],
                'discription_pc' => $request->discription_pc[$key],
                'company_name_pc' => $request->company_name_pc[$key],
                'document_number_govt' => $request->document_number_govt[$key],
                'Discription_govt' => $request->Discription_govt[$key],
                'DDR_type' => @$request->DDR_type[$key],
                'number_of_DDR' => $request->number_of_DDR[$key],
                'party_name_ddr' => $request->party_name_ddr[$key],
                'physical_stock_report' => @$request->physical_stock_report[$key],
                'discription_physical' => $request->discription_physical[$key],
                'month_physical' => $request->month_physical[$key],
                'discription_affidavits' => $request->discription_affidavits[$key],
                'company_name_affidavits' => $request->company_name_affidavits[$key],
                'discription_it' => $request->discription_it[$key],
                'other_last' => $request->other_last[$key],
            ]);
            // echo'<pre>'; print_r($sender); die;
            DB::table('new_courier_created')->insert($sender);
        }
        $response['success'] = true;
        $response['messages'] = 'Succesfully Submitted';
        return Response::json($response);    
    }

    public function editCourier($id)
    {  
        $sender = CreateCourier::find($id); 
        $couriers = DB::table('courier_companies')->select ('courier_name')->distinct()->get();
        $categorys = DB::table('catagories')->select('catagories')->distinct()->get();
        $forcompany = DB::table('for_companies')->select('for_company')->distinct()->get();
        return view('pages.update-courier',compact('sender','couriers','categorys','forcompany'));
    }

    public function updateCourier(Request $request,$id) 
    {
        $senders = CreateCourier::find($id);
        $senders->name_company = $request->name_company; 
        $senders->location = $request->location;
        $senders->telephone_no = $request->telephone_no;
        $senders->docket_no = $request->docket_no;
        $senders->docket_date = $request->docket_date;
        //$months = $request->docket_date;
        //$chg = date('F Y', strtotime($months));
        $senders->courier_name = $request->slct;
        $senders->for = $request->for;
        $senders->catagories = $request->catagories;
        $senders->distributor_agreement = $request->distributor_agreement;
        $senders->distributor_name = $request->distributor_name;
        $senders->document_type = $request->document_type;
        $senders->distributor_location = $request->distributor_location;
        $senders->remarks_distributor = $request->remarks_distributor;
        $senders->telephone_no = $request->telephone_no;
        $senders->catagories = $request->catagories;
        $senders->ledger_for = $request->ledger_for;
        $senders->type_ledger = $request->type_ledger;
        $senders->party_name = $request->party_name;
        $senders->month_invoices = $request->month_invoices;
        $senders->party_name_invoices = $request->party_name_invoices;
        $senders->month_invoices = $request->month_invoices;
        $senders->discription_i = $request->discription_i;
        $senders->bills_type = $request->bills_type;
        $senders->invoice_number_bills = $request->invoice_number_bills;
        $senders->amount_bills = $request->amount_bills;
        $senders->previouse_reading_b = $request->previouse_reading_b;
        $senders->current_reading_b = $request->current_reading_b;
        $senders->for_month_b = $request->for_month_b;
        $senders->bank_name = $request->bank_name;
        $senders->document_type_cheques = $request->document_type_cheques;
        $senders->acc_number = $request->acc_number;
        $senders->for_month_cheques = $request->for_month_cheques;
        $senders->series = $request->series;
        $senders->statement_no = $request->statement_no;
        $senders->amount_imperest = $request->amount_imperest;
        $senders->party_name_invoices = $request->party_name_invoices;
        $senders->for_month_imprest = $request->for_month_imprest;
        $senders->discription_legal = $request->discription_legal;
        $senders->company_name_legal = $request->company_name_legal;
        $senders->person_name_legal = $request->person_name_legal;
        $senders->number_of_pc = $request->number_of_pc;
        $senders->discription_pc = $request->discription_pc;
        $senders->company_name_pc = $request->company_name_pc;
        $senders->document_number_govt = $request->document_number_govt;
        $senders->Discription_govt = $request->Discription_govt;
        $senders->DDR_type = $request->DDR_type;
        $senders->number_of_DDR = $request->number_of_DDR;
        $senders->party_name_ddr = $request->party_name_ddr;
        $senders->physical_stock_report = $request->physical_stock_report;
        $senders->discription_physical = $request->discription_physical;
        $senders->month_physical = $request->month_physical;
        $senders->discription_affidavits = $request->discription_affidavits;
        $senders->company_name_affidavits = $request->company_name_affidavits;
        $senders->discription_it = $request->discription_it;
        $senders->other_last = $request->other_last;
        $senders->given_to = $request->given_to;
        $senders->checked_by = $request->checked_by;
         
        Session::flash('update', 'Data has been updated successfully');
        $senders->update();
        return redirect('courier-table');
    }

    public function destroyCourier($cmpny_id)
    {
        $cmpny = CreateCourier::find($cmpny_id);
        $cmpny->delete();
        Session::flash('deleted', 'Data has been deleted');
        return redirect()->back();
    }

}
