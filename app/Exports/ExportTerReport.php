<?php

namespace App\Exports;

use App\Models\Tercourier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportTerReport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Tercourier::all();
    }

    public function headings(): array
    {
        return [
            "ID", "Date_of_receipt", "Docket_no", "Docket_date", "Courier_id", "Unique_id", "Employee_name", "Ax_id", "Employee_id",
            "Location", "Company_name", "Terfrom_date", "Terto_date", "Details", "Amount", "Payable_amount", "Voucher_code", "Payment_status",
            "Refrence_transaction_id", "Finfect_response", "Saved_by_id", "Saved_by_name", "Delivery_date", "Remarks", "Given_to", "Status",
            "Created_at", "Updated_at"
        ];
    }
}
