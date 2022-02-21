<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourierCompany;
use App\Models\Category;
use App\Models\ForCompany;
use Session;
class TableController extends Controller
{

    public function courierCompanies()
    {
      $couriers = CourierCompany::all(); 
      return view('pages.courier-companies' , ['couriers' => $couriers]);
    }

    public function categoryTable()
    {

      $catagories = Category::all();
      return view('pages.catagories', ['catagories' => $catagories]);
      
    }

    public function forCompany()
    {
      $forcompanys = ForCompany::all(); 
      return view('pages.for-company' , ['forcompanys' => $forcompanys]);
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
   
    ///////////////////////For Company//////////////

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
