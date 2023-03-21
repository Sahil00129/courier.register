<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Po;
use DB;
use URL;
use Helper;
use Validator;
use Config;
use Session;

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

            $posdata = $query->orderBy('id', 'DESC')->paginate($peritem);
            $posdata = $posdata->appends($request->query());

            $html =  view('pos.pos-list-ajax',['posdata' => $posdata,'peritem'=>$peritem])->render();
            
            return response()->json(['html' => $html]);
        }

        $posdata = $query->orderBy('id','DESC')->paginate($peritem);
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
        return view('pos.create-po',[]);
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



        $po_number = Po::select('po_number')->latest('po_number')->first();
            $po_number = json_decode(json_encode($po_number), true);
            if (empty($po_number) || $po_number == null) {
                $addpo['po_number'] = 10001;
            } else {
                $addpo['po_number'] = $po_number['po_number'] + 1;
            }

    
        if(!empty($request->vendor_name)){
            $addpo['vendor_name'] = $request->vendor_name;
        }
        if(!empty($request->vendor_code)){
            $addpo['vendor_code'] = $request->vendor_code;
        }
        if(!empty($request->po_value)){
            $addpo['po_value'] = $request->po_value;
        }
        if(!empty($request->unit)){
            $addpo['unit'] = $request->unit;
        }
        if(!empty($request->activity)){
            $addpo['activity'] = $request->activity;
        }
        $addpo['status'] = 1;

        $savepo = Po::create($addpo);
        if($savepo){
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
}
