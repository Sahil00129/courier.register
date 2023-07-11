<?php

namespace App\Exports;

use App\Models\Tercourier;
use App\Models\ChildTercouriers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UNIDGenerateExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = ChildTercouriers::get();
        //    return $data[0]->unid_generated_date;

        $size = sizeof($data);
        $arr_instrulist_excel[] = array();
        for ($i = 0; $i < $size; $i++) {

            $get_data_ter = DB::table('tercouriers')->where('id', $data[$i]->tercourier_id)->get();
            $get_emp_data = DB::table('sender_details')->where('employee_id', $get_data_ter[0]->employee_id)->get();

            $actual_status = "";
            $status = $get_data_ter[0]->status;
            $payment_status = $get_data_ter[0]->payment_status;
            if ($status == 1) {
                $actual_status = "Received";
            } else if ($status == 2) {
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
            } else if ($status == 14) {
                $actual_status = "Unid Generated";
            } else if ($status == 0) {
                $actual_status = "Failed";
            }

            // print_r($get_emp_data);
        
            $arr_instrulist_excel[] = array(
                's.no.' => $i + 1,
                'unid'  => $data[$i]->tercourier_id,
                'unid_generate_date' => $data[$i]->unid_generated_date,
                'unid_status'    => $actual_status,
                'employee_id' => $get_emp_data[0]->employee_id,
                'emp_name'  => $get_emp_data[0]->name,
                'mob'   =>  $get_emp_data[0]->telephone_no,
                'unit' =>   $get_emp_data[0]->pfu,
                'hq' => $get_emp_data[0]->hq_state,
                // 'state' => $get_emp_data[0]->territory,
            );
        }
// exit;
        return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
            "S.No.", "UNID No", "UNID  Generation Date", "Current Status", "Empl ID", "Empl Name", "Mob No.", "Unit",
            "HQ"
        ];
    }
}
