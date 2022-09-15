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
            
            //  $lastworkingdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['last_working_date']);
              //  $lastworkingdate = $row['last_working_date']->format('d-m-Y');
              if(!empty($row['last_working_date'])){
            $month_number=explode("-",$row['last_working_date']);
            switch ($month_number[1]) {
                case "Jan":
                    $month_number[1]='01';
                  break;
                case "Feb":
                    $month_number[1]='02';
                  break;
                case "Mar":
                    $month_number[1]='03';
                  break;
                case "Apr":
                    $month_number[1]='04';
                  break;
                case "May":
                    $month_number[1]='05';
                  break;
                case "Jun":
                    $month_number[1]='06';
                case "Jul":
                    $month_number[1]='07';
                  break;
                case "Aug":
                  $month_number[1]='08';
                  break;
                case "Sep":
                    $month_number[1]='09';
                  break;
                case "Oct":
                    $month_number[1]='10';
                  break;
                case "Nov":
                    $month_number[1]='11';
                  break;
                case "Dec":
                    $month_number[1]='12';
                  break;
              }
            $final_exit_date=$month_number[0].'-'.$month_number[1].'-'.$month_number[2];
              }else{
                $final_exit_date = NULL;
              }
           
            $sender = DB::table('sender_details')
                ->where('ax_id', '=', $row['ax_id'])
                ->first();
               
            if(empty($sender)) { 
                if($row['type'] == 'Employee'){
                    return new Sender([
                        'ax_id' => $row['ax_id'],
                        'name'  => $row['name'],
                        'employee_id' => $row['employee_id'],
                        'type'    => $row['type'],
                        'location' => $row['location'],
                        'telephone_no' => (float)$row['telephone_no'],
                        'status' => $row['status'],
                         'last_working_date' => $final_exit_date,
                    ]);
                }
            }else{
               DB::table('sender_details')
               ->where('ax_id', $row['ax_id'])->update(['status' => $row['status'] ]);
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
