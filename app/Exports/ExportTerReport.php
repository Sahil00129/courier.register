<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerReport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data=Tercourier::select('id','created_at','saved_by_name','updated_by_name','updated_at')->get();
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        for($i=0;$i<$size;$i++)
        {
            $val= explode(" ",$data[$i]->created_at);
            $date1=$val[0];
            $time1=$val[1];
            $id=$data[$i]->id;
            $saved_by_name=$data[$i]->saved_by_name;
            $updated_by_name=$data[$i]->updated_by_name;
            $val2= explode(" ",$data[$i]->updated_at);
            $date2=$val2[0];
            $time2=$val2[1];

            $arr_instrulist_excel[] = array(
                'id'  => $id,
                'saved_by_name'   => $saved_by_name,
                'created_at'    => $date1,
                'created_time' => $time1,
                'updated_by_name'  => $updated_by_name,
                'updated_at'   => $date2,
                'updated_time' => $time2
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
            "ID","Created_by", "Created_date","Created_time","Updated_by", "Updated_date","Updated_time"
        ];
    }
}
