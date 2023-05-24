<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerFullList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Tercourier::with('CourierCompany', 'SenderDetail')->where('ter_type', 2)->get();

        $size = sizeof($data);
        $arr_instrulist_excel[] = array();
        for ($i = 0; $i < $size; $i++) {
            $id = $data[$i]->id;
            $sum1 = 0;
            $pfu = "";
            $status = $data[$i]->status;
            $payment_status = $data[$i]->payment_status;
            if ($status == 2) {
                $actual_status = "Handover";
            } else if ($status == 3) {
                $actual_status = "Sent to FinFect";
            } else if ($status == 4 && $payment_status == 2) {
                $actual_status = "Pay Later";
            } else if ($status == 4 && $payment_status == 3) {
                $actual_status = "F&F Pay";
            } else if ($status == 5) {
                $actual_status = "Paid";
            } else if ($status == 6) {
                $actual_status = "Cancel";
            } else if ($status == 7) {
                $actual_status = "Partially Paid";
            } else if ($status == 8) {
                $actual_status = "Rejected";
            } else if ($status == 9) {
                $actual_status = "Unknown";
            } else if ($status == 11) {
                $actual_status = "Handover Created";
            } else if ($status == 12) {
                $actual_status = "Unit Changed";
            } else if ($status == 13) {
                $actual_status = "Payment Reject";
            } else if ($status == 0) {
                $actual_status = "Failed";
            }

            if ($data[$i]->final_payable != "" || $data[$i]->final_payable != 0 || $data[$i]->final_payable != NULL) {
                $deductions = (int)$data[$i]->amount - (int)$data[$i]->final_payable;
                $paid_amount = $data[$i]->final_payable;
            } else {


                if ($data[$i]->payable_amount != "" || $data[$i]->payable_amount != NULL) {
                    $decode2 = json_decode($data[$i]->payable_amount);

                    if (gettype($decode2) == "array") {
                        $sum1 = array_sum($decode2);
                        $deductions = (int)$data[$i]->amount - (int)$sum1;
                        $paid_amount = $sum1;
                    } else {
                        $deductions = (int)$data[$i]->amount - (int)$data[$i]->payable_amount;
                        $paid_amount = $data[$i]->payable_amount;
                    }
                } else {
                    $deductions = "";
                    $paid_amount = "";
                }
            }
            $ax_id = $data[$i]->ax_id;
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
                'handover_date' => $data[$i]->handover_date,
                'verify_ter_date' => $data[$i]->verify_ter_date,
                'sent_to_finfect_date' => $data[$i]->sent_to_finfect_date,
                'finfect_response' => $data[$i]->finfect_response,
                'paid_date' => $data[$i]->paid_date,
                'amount' => $data[$i]->amount,
                'ax_payable_amount' => $data[$i]->payable_amount,
                'final_payable' => $paid_amount,
                'deductions' => $deductions,
                'sender_name' => $data[$i]->sender_name,
                'ax_id'  => $data[$i]->ax_id,
                'employee_id'   => $data[$i]->employee_id,
                'location' => $data[$i]->location,
                'company_name' => $pfu,
                'ter_period_from' => $data[$i]->terfrom_date,
                'ter_period_to' => $data[$i]->terto_date,
                'courier_name' => @$data[$i]->CourierCompany->courier_name,
                'docket_no' => $data[$i]->docket_no,
                'docket_date' => $data[$i]->docket_date,
                'ax_voucher_code' => $data[$i]->voucher_code,
            );
        }

        return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
            "UN ID", "Status", "Date of Receipt", "Handover Date", "Verify TER Date", "Sent to Finfect date", "Finfect Response",
            "Paid from Finfect Date", "TER  Amount Received", "AX Payable Amount", "Amount Paid From Finfect", "Deductions", "Sender Name", "Ax ID", "Employee ID", "Location", "Company Name",
            "Ter Period From", "TER Period To", "Courier Name",
            "Docket No", "Docket Date", "AX Voucher Code"
        ];
    }
}
