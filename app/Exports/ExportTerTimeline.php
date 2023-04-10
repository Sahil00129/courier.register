<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerTimeline implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Tercourier::select('*')->where('ter_type',2)->get();
    
            $size = sizeof($data);
            $arr_instrulist_excel[] =array();
            for ($i = 0; $i < $size; $i++) {
                $status = $data[$i]->status;
                if($status == 1 || $status == 2 || $status == 3 || $status == 4 || $status == 5 ||$status == 6 ||$status == 0)
               {
                $id = $data[$i]->id;
                $sum1=0;
                if ($status == 1) {
                    $actual_status = "Received";
                } else if ($status == 2) {
                    $actual_status = "Handover";
                } else if ($status == 3) {
                    $actual_status = "Sent to FinFect";
                } else if ($status == 4) {
                    $actual_status = "Pay Later";
                } else if ($status == 5) {
                    $actual_status = "Paid";
                } else if ($status == 6) {
                    $actual_status = "Cancel";
                } else if ($status == 0) {
                    $actual_status = "Failed";
                }

                if ($data[$i]->final_payable != "" || $data[$i]->final_payable != 0 || $data[$i]->final_payable != NULL) {
                    $deductions = (int)$data[$i]->amount - (int)$data[$i]->final_payable;
                    $paid_amount=$data[$i]->final_payable;
                 
                } 
                else {
 
       
                    if($data[$i]->payable_amount !="" || $data[$i]->payable_amount != NULL){
                        $decode2 = json_decode($data[$i]->payable_amount);

                       if (gettype($decode2) == "array") {
                        $sum1=array_sum($decode2);
                            $deductions = (int)$data[$i]->amount -(int)$sum1;
                            $paid_amount=$sum1;

                            
                        } else {
                            $deductions = (int)$data[$i]->amount - (int)$data[$i]->payable_amount;
                            $paid_amount=$data[$i]->payable_amount;

                        }

                    }else{
                        $deductions = "";
                            $paid_amount="";
                    }
               
                }
             
              
                }

    
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'id'  => $id,
                    'status'   => $actual_status,
                    'receiving_date'    => $data[$i]->received_date,
                    'handover_date' => $data[$i]->handover_date,
                    'sent_to_finfect_date'  => $data[$i]->sent_to_finfect_date,
                    'paid_date'   => $data[$i]->paid_date,
                    'utr' => $data[$i]->utr,
                    'remarks' => $data[$i]->hr_admin_remark,
                    'amount' => $data[$i]->amount,
                    'paid_amount' => $paid_amount,
                    'deductions' => $deductions,
                    'user_id' => $data[$i]->updated_by_id
                );

            }
   
            return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
            "S.No.", "TER ID", "Status", "Receiving Date", "Handover Date", "Sent to finfect Date", "Paid date", "UTR", "Remarks", "TER total Amount",
            "TER Paid Amount", "Deductions", "User Id"
        ];
    }
}
