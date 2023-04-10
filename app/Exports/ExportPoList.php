<?php

namespace App\Exports;

use App\Models\PO;
use App\Models\Sender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPoList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = PO::get();
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        for($i=0;$i<$size;$i++)
        {
      
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'po_number'  => $data[$i]->po_number,
                    'vendor_code'  => $data[$i]->vendor_code,
                    'vendor_name' => $data[$i]->vendor_name,
                    'po_value' => $data[$i]->po_value,
                    'unit' =>  $data[$i]->unit,
                    'activity' => $data[$i]->activity
                );

            }
   
            return collect($arr_instrulist_excel);

    }
    

    public function headings(): array
    {
        return [
            "S.No.","Po Number", "Vendor Code","Vendor Name",
            "PO Value", "Unit", "Activity"
        ];
    }
}
