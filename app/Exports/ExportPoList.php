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
        $data = PO::with('PoTercouriers')->get();
      
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        $total = array();
        for($i=0;$i<$size;$i++)
        {
            
            for($j=0;$j<sizeof($data[$i]->PoTercouriers);$j++)
            {
                // echo "<pre>";
                // print_r ($data[$i]->PoTercouriers[$j]->total_amount);
                // exit;
                $total[] = (int)$data[$i]->PoTercouriers[$j]->total_amount;
            }
            $total_sum = array_sum($total);
      
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'po_number'  => $data[$i]->po_number,
                    'vendor_unique_id'  => $data[$i]->vendor_unique_id,
                    'vendor_name' => $data[$i]->vendor_name,
                    'unit' =>  $data[$i]->unit,
                    'po_date'=>  $data[$i]->po_date,
                    'po_value' => $data[$i]->po_value,
                    'invoice_value' => $total_sum,
                    'remaining_value' => (int)$data[$i]->initial_po_value - $total_sum
                );

            }
   
            return collect($arr_instrulist_excel);

    }
    

    public function headings(): array
    {
        return [
            "S.No.","Po Number", "Vendor Unique Id","Vendor Name","Unit","Po Date",
            "PO Value", "Invoice Value", "Remaning Value"
        ];
    }
}
