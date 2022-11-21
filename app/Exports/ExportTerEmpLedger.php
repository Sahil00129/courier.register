<?php

namespace App\Exports;

use App\Models\EmployeeBalance;
use App\Models\Sender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerEmpLedger implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = EmployeeBalance::with('SenderDetailsTable')->get();
        $size=sizeof($data);
        // $val="";
        $arr_instrulist_excel[] =array();
        for($i=0;$i<$size;$i++)
        {
        $sender_table=Sender::select('*')->where('employee_id',$data[$i]->employee_id)->get();
    

    
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'employee_id'  => $data[$i]->employee_id,
                    'ax_id'  => $data[$i]->SenderDetailsTable->ax_id,
                    'name' => $data[$i]->SenderDetailsTable->name,
                    'status' => $data[$i]->SenderDetailsTable->status,
                    'balance' =>  $data[$i]->current_balance,
                    'advance' => $data[$i]->advance_amount
                );

            }
   
            return collect($arr_instrulist_excel);

    }
    

    public function headings(): array
    {
        return [
            "S.No.","Employee ID", "AX ID","Employee Name",
            "Status", "Current Balance", "Advance"
        ];
    }
}
