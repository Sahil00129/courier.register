<?php

namespace App\Exports;

use App\Models\Update_table_data;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerUpdates implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    { 
        $data=Update_table_data::with('SaveUpdatedData')->get();
        // echo"<pre>";
        // print_r($data);
        // return $data;
        $size=sizeof($data);
        // $val="";
         
        for($i=0;$i<$size;$i++)
        {
            $id=$data[$i]->id;
            $updated_id=$data[$i]->updated_id;
            $updated_field=$data[$i]->updated_field;
            $remarks=$data[$i]->SaveUpdatedData->hr_admin_remark;

            $arr_instrulist_excel[] = array(
                'id'  => $id,
                'updated_id' => $updated_id,
                'updated_field'=>$updated_field,
                'remarks'    => $remarks,
               );
            
            // echo"<pre>";
            // return[$id,$saved_by_name,$date1,$time1,$updated_by_name,$date2,$time2];
            // print_r($time);
        }

        return collect($arr_instrulist_excel);
       
        // return Tercourier::select('id','saved_by_name','created_at','updated_by_name','updated_at')->get();
    }

    public function headings(): array
    {
        return [
            "S.No.","TER_ID","Updated_data", "Remarks"
        ];
    }
}
