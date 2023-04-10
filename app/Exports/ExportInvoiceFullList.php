<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInvoiceFullList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Tercourier::with('CourierCompany', 'SenderDetail')->where('ter_type',1)->get();
    
            $size = sizeof($data);
            $arr_instrulist_excel[] =array();
            for ($i = 0; $i < $size; $i++) {
                $id = $data[$i]->id;
                $sum1=0;
                $pfu="";
                $status = $data[$i]->status;
                if ($status == 1) {
                    $actual_status = 'Received at Recption';
    
                } elseif ($status == 11) {
                    $actual_status = 'Handover to Sourcing';
    
                } elseif ($status == 2) {
                    $actual_status = 'Received at Sourcing';
    
                } elseif ($status == 3) {
                    $actual_status = 'Verified at Sourcing';
    
                } elseif ($status == 4) {
                    $actual_status = 'Handover to Accounts';
    
                } elseif ($status == 5) {
                    $actual_status = 'Unpaid';
    
                } elseif ($status == 6) {
                    $actual_status = 'Paid';
    
                } elseif ($status == 7) {
                    $actual_status = 'Handover to Scanning';
    
                } elseif ($status == 8) {
                    $actual_status = 'Received at Scanning';
    
                } elseif ($status == 9) {
                    $actual_status = 'Invoice Scanned';
    
                } else {
                    $actual_status = 'Failed';
                    }


    // dd($data[$i]->CourierCompany->courier_name);
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => $id,
                    'status'   => $actual_status,
                    'date_of_receipt'    => $data[$i]->date_of_receipt,
                    'handover_date'=>$data[$i]->handover_date,
                    'basic_amount' => $data[$i]->basic_amount,
                    'total_amount'=>$data[$i]->total_amount,
                    'invoice_no' => $data[$i]->invoice_no,
                    'invoice_date' => $data[$i]->invoice_date,
                    'po_value' => $data[$i]->po_value,
                    'sourcing_remarks'  => $data[$i]->sourcing_remarks,
                    'scanning_remarks'   => $data[$i]->scanning_remarks,
                    'vendor_name' => $data[$i]->sender_name,
                    'vendor_code' => $data[$i]->employee_id,
                    'pfu' => $data[$i]->pfu,
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
            "UN ID", "Status", "Date of Receipt","Handover Date","Basic Amount","Total Amount","Invoice No","Invoice Date","Po Value", "Sourcing Remarks", "Scanning Remarks", "Vendor Name", "Vendor Code", "PFU","Courier Name", 
           "Docket No", "Docket Date"
        ];
    }
}
