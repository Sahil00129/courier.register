<?php

namespace App\Imports;
use DB;
use App\Models\Sender;
use App\Models\CourierCompany;
use App\Models\Category;
use App\Models\ForCompany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BulkImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if($_POST['import_type'] == 1){
           //echo "<pre>"; print_r($row);die;
           $sender = DB::table('sender_details')
           ->where('ax_id', '=', $row['ax_id'])
           ->where('employee_id', '=', $row['employee_id'])
           ->first();
           if(is_null($sender)) {
                return new Sender([
                    'ax_id' => $row['ax_id'],
                    'name'  => $row['name'],
                    'employee_id'  => $row['employee_id'],
                    'type'    => $row['type'],
                    'location' => $row['location'],
                    'telephone_no' =>$row['telephone_no'],
                ]);
            }else{
                DB::table('sender_details')
                ->where('name',$row['name'])->update([ 'name' => $row['name'], 'type' => $row['type'], 'location' => $row['location'], 'telephone_no' => $row['telephone_no'] ]);
            }
        }

        if($_POST['import_type'] == 2){
         //echo "<pre>"; print_r($row);die;
         $CU = DB::table('courier_companies')
         ->where('courier_name', '=', $row['courier_name'])
         ->first();
         
         if(is_null($CU)) {
            return new CourierCompany([
                'courier_name'  => $row['courier_name'],
                'phone'  => $row['phone'],
            ]);
         }
    }
    
   if($_POST['import_type'] == 3){
    //echo "<pre>"; print_r($row['department']);die;
    $catagory = DB::table('catagories')
    ->where('catagories', '=', $row['catagories'])
    ->first();
    if(is_null($catagory)) {
       return new Category([
           'catagories'  => $row['catagories']
       ]);      
    } 
}
if($_POST['import_type'] == 4){
    //echo "<pre>"; print_r($row['department']);die;
    $for = DB::table('for_companies')
    ->where('for_company', '=', $row['for_company'])
    ->first();
    if(is_null($for)) {
       return new ForCompany([
           'for_company'  => $row['for_company']
       ]);      
    } 
}

}
}
