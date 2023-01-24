<?php

namespace App\Exports;

use App\Models\Tercourier;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportHandShakeList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Tercourier::with('CourierCompany', 'SenderDetail')->where('status',3)->get();

        $size = sizeof($data);

        $arr_instrulist_excel[] =array();
        for ($i = 0; $i < $size; $i++) {
            $id = $data[$i]->id;
            $status = $data[$i]->status;
            $actual_status = "";
            if ($status == 3) {
                $actual_status = "Sent to FinFect";
            }
            
            $sent_to_finfect=$data[$i]->sent_to_finfect_date;
            $refrence_txn_id = $data[$i]->refrence_transaction_id;

            $response_from_finfect = $data[$i]->finfect_response;
            $employee_id=$data[$i]->employee_id;
            $get_sender_data=DB::table('sender_details')->where('employee_id',$employee_id)->get();

            // dd($data[$i]->CourierCompany->courier_name);
            if ($actual_status == "") {
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => "",
                    'status'   => "",
                    'sent_to_finfect_date'=>"",
                    'refrence_txn_id'    => "",
                    'response_from_finfect' => "",
                    'employee_id'=>'',
                    'grade'=>'',
                );
            } else {
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => $id,
                    'status'   => $actual_status,
                    'sent_to_finfect_date'=>$sent_to_finfect,
                    'refrence_txn_id'    => $refrence_txn_id,
                    'response_from_finfect' => $response_from_finfect,
                    'employee_id'=>$employee_id,
                    'grade'=>$get_sender_data[0]->grade
                );
            }
        }

        return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
            "UN ID", "Status","Date of Sent to Fifect", "Refrence Transaction", "Response From FinFect","Employee ID","Unit"
        ];
    }
}
