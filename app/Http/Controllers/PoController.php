<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Po;
use App\Models\PoItem;
use DB;
use URL;
use Helper;
use Validator;
use Config;
use Session;
use App\Exports\ExportPoList;
use Maatwebsite\Excel\Facades\Excel;


class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $peritem = Config::get('variable.PER_PAGE');
        $query = Po::query();
        
        if ($request->ajax()) {
            if(isset($request->resetfilter)){
                Session::forget('peritem');
                $url = URL::to($this->prefix.'/'.$this->segment);
                return response()->json(['success' => true,'redirect_url'=>$url]);
            }
            $query = $query;

            if(!empty($request->search)){
                $search = $request->search;
                $searchT = str_replace("'","",$search);
                $query->where(function ($query)use($search,$searchT) {
                    $query->where('po_number', 'like', '%' . $search . '%')
                    ->orWhere('vendor_code', 'like', '%' . $search . '%')
                    ->orWhere('vendor_name', 'like', '%' . $search . '%')
                    ->orWhere('po_value', 'like', '%' . $search . '%')
                    ->orWhere('unit', 'like', '%' . $search . '%');
                });
            }

            if($request->peritem){
                Session::put('peritem',$request->peritem);
            }
      
            $peritem = Session::get('peritem');
            if(!empty($peritem)){
                $peritem = $peritem;
            }else{
                $peritem = Config::get('variable.PER_PAGE');
            }

            $posdata = $query->with('PoTercouriers')->orderBy('id', 'DESC')->paginate($peritem);
            $posdata = $posdata->appends($request->query());

            $html =  view('pos.pos-list-ajax',['posdata' => $posdata,'peritem'=>$peritem])->render();
            
            return response()->json(['html' => $html]);
        }

        $posdata = $query->with('PoTercouriers')->orderBy('id','DESC')->paginate($peritem);
        // dd($posdata);
        // echo "<pre>";
        // print_r($posdata[3]['PoTercouriers']);
        // exit;
        // $sum=0;
        // for($i=0;$i<sizeof($posdata);$i++)
        // {
        //     $sum=
        //     $posdata['total_invoice']=$

        // }
        $posdata = $posdata->appends($request->query());
        
        return view('pos.pos-list', ['posdata' => $posdata, 'peritem'=>$peritem]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state_json = file_get_contents('assets/json/states-and-districts.json');
        $state_json_data = json_decode($state_json, true);
        return view('pos.create-po',['state_json_data' => $state_json_data['states']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            // 'po_number'    => 'required|unique:pos',
            // 'vendor_name' => 'required', 
            // 'po_value'  => 'required',
            // 'unit'  => 'required',
        );
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails())
        {
            $errors                 = $validator->errors();
            $response['success']    = false;
            $response['validation'] = false;
            $response['formErrors'] = true;
            $response['errors']     = $errors;
            return response()->json($response);
        }

        $data=$request->all();
     
        $item_size = sizeof($data['data']);


        $po_number = Po::select('po_number')->latest('po_number')->first();
            $po_number = json_decode(json_encode($po_number), true);
            if (empty($po_number) || $po_number == null) {
                $addpo['po_number'] = 230001;
            } else {
                $addpo['po_number'] = $po_number['po_number'] + 1;
            }
         
            
        if(!empty($request->vendor_unique_id)){
            $addpo['vendor_unique_id'] = $request->vendor_unique_id;
        }
        // return $addpo;
    
        if(!empty($request->vendor_name)){
            $addpo['vendor_name'] = $request->vendor_name;
        }
        if(!empty($request->vendor_code)){
            $addpo['vendor_code'] = $request->vendor_code;
        }
        if(!empty($request->po_value)){
            $addpo['po_value'] = $request->po_value;
            $addpo['initial_po_value'] = $request->po_value;
        }
        if(!empty($request->unit)){
            $addpo['unit'] = $request->unit;
        }
        if(!empty($request->activity)){
            $addpo['activity'] = $request->activity;
        }

        if(!empty($request->total_tax_amount)){
            $addpo['total_tax_amount'] = $request->total_tax_amount;
        }
        if(!empty($request->gst_rate)){
            $addpo['gst_rate'] = $request->gst_rate;
        }
        if(!empty($request->gst_amount)){
            $addpo['gst_amount'] = $request->gst_amount;
        }
        if(!empty($request->source_po_num)){
            $addpo['source_po_num'] = $request->source_po_num;
        }
        if(!empty($request->erp_num)){
            $addpo['erp_num'] = $request->erp_num;
        }
        if(!empty($request->state)){
            $addpo['state'] = $request->state;
        }
        if(!empty($request->crop)){
            $addpo['crop'] = $request->crop;
        }
        if(!empty($request->amm_agm)){
            $addpo['amm_agm'] = $request->amm_agm;
        }
        if(!empty($request->product)){
            $addpo['product'] = $request->product;
        }
      
        $addpo['po_date'] = date('Y-m-d');

        $addpo['status'] = 1;

        $savepo = Po::create($addpo);

    
        $add_items['po_id'] = $savepo->id;
        $save_items = "";

        if($savepo){

        for($i=1;$i<=$item_size;$i++)
        {

            if(!empty($data['data'][$i]['item_type'])){
                $add_items['item_type'] = $data['data'][$i]['item_type'];
            }
            if(!empty($data['data'][$i]['item_desc'])){
                $add_items['item_desc'] = $data['data'][$i]['item_desc'];
            }
            if(!empty($data['data'][$i]['quantity'])){
                $add_items['quantity'] = $data['data'][$i]['quantity'];
            }
            if(!empty($data['data'][$i]['unit_price'])){
                $add_items['unit_price'] = $data['data'][$i]['unit_price'];
            }
            if(!empty($data['data'][$i]['total_amount'])){
                $add_items['total_amount'] = $data['data'][$i]['total_amount'];
            }
         
            $save_items = PoItem::create($add_items);
        }
    }

       

        if($save_items){
            $response['success']    = true;
            $response['page']       = 'create-pos';
            $response['error']      = false;
            $response['success_message'] = "PO created successfully";
            $response['redirect_url'] = URL::to('/pos');
        }else{
            $response['success']       = false;
            $response['error']         = true;
            $response['error_message'] = "Can not created po please try again";
        }
        // echo "<pre>"; print_r($response); die;
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function submit_cancel_remarks(Request $request)
    {
        $data=$request->all();
        $remarks=$data['cancel_remarks'];
        $po_number= $data['po_number'];
        $db= Po::where('po_number',$po_number)->where('status',1)->update(['cancel_po_remarks'=>$remarks,'status'=>4]);
        return $db;
        
    }

    public function download_po_list()
    {
        return Excel::download(new ExportPoList, 'po_list.xlsx');
        // return (new ExportPoList);
    }
}
