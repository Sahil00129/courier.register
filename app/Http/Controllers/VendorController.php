<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorDetails;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set('Asia/Kolkata');


class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorTable(Request $request)
    {
        $vendors = VendorDetails::all();
        if (Auth::check()) {
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->name;
           
        }
        return view('pages.vendors-table',  ['vendors' => $vendors,'role' =>$name])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

 public function add_vendor_details(Request $request)
 {
    $data=$request->all();
    $get_vendor=VendorDetails::where('erp_code',$data['erp_code'])->first();
    // return $get_vendor;
    if(empty($get_vendor)){
    $add_data=VendorDetails::create($data);
    }
    else{
        $add_data=0;
    }
    return $add_data;

 }

 public function get_vendors($type)
 {
    $get_vendors=VendorDetails::where('unit',$type)->get();
    return $get_vendors;
 }
}
