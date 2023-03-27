<?php

namespace App\Exports;

use App\Models\VendorDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVendorList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = VendorDetails::get();
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        for($i=0;$i<$size;$i++)
        {
      
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'vendor_code'  => $data[$i]->erp_code,
                    'vendor_name' => $data[$i]->name,
                    'unit' =>  $data[$i]->unit,
                );

            }
   
            return collect($arr_instrulist_excel);

    }
    

    public function headings(): array
    {
        return [
            "S.No.", "Vendor Code","Vendor Name",
           "Unit"
        ];
    }
}
