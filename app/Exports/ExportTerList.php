<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Tercourier::with('CourierCompany', 'SenderDetail')->where('ter_type',2)->get();
    
            $size = sizeof($data);
            $arr_instrulist_excel[] =array();
            for ($i = 0; $i < $size; $i++) {
                $id = $data[$i]->id;
                $sum1=0;
                $pfu="";
                $status = $data[$i]->status;
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
                } else if ($status == 7) {
                    $actual_status = "Partially Paid";
                }else if ($status == 8) {
                    $actual_status = "Rejected";
                }else if ($status == 9) {
                    $actual_status = "Unknown";
                }
                else if ($status == 0) {
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

                $ax_id=$data[$i]->ax_id;
                if (!empty($ax_id)) {
                    $new_data = explode("-", $ax_id);
                    if ($new_data[0] == "FAMA") {
                        $pfu = "MA2";
                    } else if ($new_data[0] == "FAGMA") {
                        $pfu = "MA4";
                    } else if ($new_data[0] == "FAGSD") {
                        $pfu = "SD3";
                    } else if ($new_data[0] == "FAPL") {
                        $pfu = "SD1";
                    }
                }

    // dd($data[$i]->CourierCompany->courier_name);
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => $id,
                    'status'   => $actual_status,
                    'date_of_receipt'    => $data[$i]->date_of_receipt,
                    'handover_date'=>$data[$i]->handover_date,
                    'sender_name' => $data[$i]->sender_name,
                    'ax_id'  => $data[$i]->ax_id,
                    'employee_id'   => $data[$i]->employee_id,
                    'location' => $data[$i]->location,
                    'company_name' => $pfu,
                    'amount' => $data[$i]->amount,
                    'ter_period_from' => $data[$i]->terfrom_date,
                    'ter_period_to' => $data[$i]->terto_date,
                    'other_details' => $data[$i]->details,
                    'remarks' => $data[$i]->remarks,
                    'given_to'=>$data[$i]->given_to,
                    'courier_name'=>@$data[$i]->CourierCompany->courier_name,
                    'docket_no'=>$data[$i]->docket_no,
                    'docket_date'=>$data[$i]->docket_date,
                );

            }
   
            return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
             "UN ID", "Status", "Date of Receipt","Handover Date","Sender Name", "Ax ID", "Employee ID", "Location", "Company Name", "TER  Amount",
            "Ter Period From","TER Period To","Other Details","Remarks","Given To","Courier Name",
            "Docket No", "Docket Date"
        ];
    }
}
