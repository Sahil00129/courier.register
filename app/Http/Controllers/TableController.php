<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourierCompany;
use App\Models\Category;
use App\Models\ForCompany;
use Session;
use Validator;
use URL;

class TableController extends Controller
{
    public function courierCompanies(Request $request)
    {
        $couriers = CourierCompany::all(); 
        return view('pages.courier-companies' , ['couriers' => $couriers])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function categoryTable(Request $request)
    {
        $catagories = Category::all();
        return view('pages.catagories', ['catagories' => $catagories])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function forCompany(Request $request)
    {
        $forcompanys = ForCompany::all(); 
        return view('pages.for-company' , ['forcompanys' => $forcompanys])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function createcourierCompany(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
       
        $rules = array(
            'courier_name'  => 'required',
        );
        $validator = Validator::make($request->all() , $rules);
        if($validator->fails())
        {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }
        if(!empty($request->courier_name)){
            $couriercompany['courier_name'] = $request->courier_name;
        }
        if(!empty($request->phone)){
            $couriercompany['phone'] = $request->phone;
        }
        $savecompany = CourierCompany::create($couriercompany); 
        if($savecompany){
            $url = URL::to($this->prefix.'/courier-company');
            $response['success'] = true;
            $response['page'] = 'couriercompany';
             $response['success_message'] = "Courier Company created successfully";
            $response['error'] = false;
            $response['redirect_url'] = $url;
        }else{
            $response['success'] = false;
            $response['error_message'] = "Can not created courier company please try again";
            $response['error'] = true;
        }

        return response()->json($response);
    }

    /////////////Courier Company//////////////////
    public function editcourierCompany($id)
    {
        $forcourier = CourierCompany::find($id); 
        return response()->json([
            'status' =>200,
            'forcourier' => $forcourier,
        ]);
    }

    public function updatecourierCompany(Request $request)
    {
        $courier_id = $request->courier_id;
        $addcourier = CourierCompany::find($courier_id);
        $addcourier->courier_name = $request->courier_name;
        $addcourier->phone = $request->phone;
        Session::flash('update', 'Data has been updated successfully');
        $addcourier->update();
        return redirect()->back();
    }
  
    public function destroycourierCompany($courier_id)
    {
        $courier = CourierCompany::find($courier_id); 
        //Session::flash('delete', 'deleted');
        $courier->delete();
        Session::flash('deleted', 'Data has been deleted');
        return redirect()->back();
    }

     ////////////////////Category//////////////////////
    public function editCat($id)
    {
        $newcata = Category::find($id);
        return response()->json([
            'status' =>200,
            'newcata' => $newcata,
        ]);
    }

    public function updateCatagories(Request $request)
    {
        $cat_id = $request->cat_id;
        $addnew = Category::find($cat_id);
        $addnew->catagories = $request->catagories;
        Session::flash('update', 'Data has been updated successfully');
        $addnew->update();
  
        return redirect()->back();
    }

   public function destroyCatagories($catagorie_id)
   {
      $cmpny = Category::find($catagorie_id); 
      //Session::flash('delete', 'deleted');
      $cmpny->delete();
      Session::flash('deleted', 'Data has been deleted');
      return redirect()->back();
    }

    ///// Create For Company////
    public function createforCompany(Request $request)
    {
        $this->prefix = request()->route()->getPrefix();
       
        $rules = array(
                'for_company'     => 'required',
            );
        $validator = Validator::make($request->all() , $rules);
        if($validator->fails())
        {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }
        if(!empty($request->for_company)){
            $forcompany['for_company'] = $request->for_company;
        }
        $savecompany = ForCompany::create($forcompany); 
        if($savecompany){
            $url = URL::to($this->prefix.'/for-company');
            $response['success'] = true;
            $response['page'] = 'forcompany';
             $response['success_message'] = "Receiving Company created successfully";
            $response['error'] = false;
            $response['redirect_url'] = $url;
        }else{
            $response['success'] = false;
            $response['error_message'] = "Can not created Receiving company please try again";
            $response['error'] = true;
        }

        return response()->json($response);
    }
   
    ///////////////////////Edit For Company//////////////

    public function editforCompany($id)
    {
        $forcomp = ForCompany::find($id);
        return response()->json([
            'status' =>200,
            'forcomp' => $forcomp,
        ]);
    }

    public function updateforCompany(Request $request)
    {
        $for_id = $request->for_id;
        $addfor = ForCompany::find($for_id);
        $addfor->for_company = $request->for_company;
        Session::flash('update', 'Data has been updated successfully');
        $addfor->update();
        return redirect()->back();

    }

    public function destroyforCompany($forcompany_id)
    {
        $forcompany = ForCompany::find($forcompany_id); 
        //Session::flash('delete', 'deleted');
        $forcompany->delete();
        Session::flash('deleted', 'Data has been deleted');
        return redirect()->back();
    }


}
