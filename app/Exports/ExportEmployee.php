<?php

namespace App\Exports;

use App\Models\Sender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportEmployee implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sender::all();
    }
    public function headings(): array
    {
        return ["ID", "Ax_ID", "Name","Designation","Employee_ID","Grade","User_Type","Location","HQ_State","Territory","Team",
               "Telephone_no","Date_of_joining","Last_working_date","Category","Date_of_birth","Education_qualification","Gender",
            "Marital_Status","Official_email_id","Personal_email_id","Uan_number","Esic_status","Esic_no","Compliance_branch",
            "Department","Pan", "Aadhar_number","Account_number","Address_1", "Address_2", "Address_3", "Address_district", 
             "Address_state","Address_pin_code","Beneficiary_name","Ifsc","Bank_name","Branch_name","Account_base_type",
            "Transfer_type","Account_type","Status","Created_at","Updated_at"];
    }
}
