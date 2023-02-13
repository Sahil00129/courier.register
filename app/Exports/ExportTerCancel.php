<?php

namespace App\Exports;

use App\Models\Terdatacancel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerCancel implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    { 
        $data=Terdatacancel::get();
        // dd($data);
        // return $data;
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        
        for($i=0;$i<$size;$i++)
        {
            $id=$data[$i]->id;
            $updated_id=$data[$i]->updated_id;
            $remarks=$data[$i]->remarks;
            $old_status=$data[$i]->old_status;
            $updated_user_id=$data[$i]->updated_by_user_id;
            $updated_name=$data[$i]->updated_by_user_name;

            $arr_instrulist_excel[] = array(
                'id'  => $id,
                'updated_id' => $updated_id,
                'old_status'=>$old_status,
                'remarks'    => $remarks,
                'updated_user_id' =>$updated_user_id,
                'updated_name'=>$updated_name
               );
            
            // echo"<pre>";
            // return[$id,$saved_by_name,$date1,$time1,$updated_by_name,$date2,$time2];
            // print_r($data[$i]);
        }
// exit;
        return collect($arr_instrulist_excel);
       
        // return Tercourier::select('id','saved_by_name','created_at','updated_by_name','updated_at')->get();
    }

    public function headings(): array
    {
        return [
            "S.No.","TER_ID","OLD_STATUS", "Remarks","Updated User Id","Updated User Name",
        ];
    }
}
