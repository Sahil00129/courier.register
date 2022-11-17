<?php

namespace App\Exports;

use App\Models\Tercourier;
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

        for ($i = 0; $i < $size; $i++) {
            $id = $data[$i]->id;
            $status = $data[$i]->status;
            $actual_status = "";
            if ($status == 3) {
                $actual_status = "Sent to FinFect";
            }

            $refrence_txn_id = $data[$i]->refrence_transaction_id;

            $response_from_finfect = $data[$i]->finfect_response;

            // dd($data[$i]->CourierCompany->courier_name);
            if ($actual_status == "") {
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => "",
                    'status'   => "",
                    'refrence_txn_id'    => "",
                    'response_from_finfect' => "",
                );
            } else {
                $arr_instrulist_excel[] = array(
                    // 's.no.' => $i + 1,
                    'id'  => $id,
                    'status'   => $actual_status,
                    'refrence_txn_id'    => $refrence_txn_id,
                    'response_from_finfect' => $response_from_finfect,
                );
            }
        }

        return collect($arr_instrulist_excel);
    }

    public function headings(): array
    {
        return [
            "UN ID", "Status", "Refrence Transaction", "Response From FinFect"
        ];
    }
}
