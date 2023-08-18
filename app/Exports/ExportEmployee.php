<?php

namespace App\Exports;

use App\Models\Sender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ExportEmployee implements FromCollection, WithHeadings, WithMapping
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
        return [
            "ID", "Ax_ID", "Iag_Code", "PFU", "Name", "Designation", "Employee_ID", "Grade", "User_Type", "Location", "HQ_State", "Territory", "Team",
            "Telephone_no", "Date_of_joining", "Last_working_date", "Category", "Date_of_birth", "Education_qualification", "Gender",
            "Marital_Status", "Official_email_id", "Personal_email_id", "Uan_number", "Esic_status", "Esic_no", "Compliance_branch",
            "Department", "Pan", "Aadhar_number", "Account_number", "Address_1", "Address_2", "Address_3", "Address_district",
            "Address_state", "Address_pin_code", "Beneficiary_name", "Ifsc", "Bank_name", "Branch_name", "Account_base_type",
            "Transfer_type", "Account_type", "Status", "OTP", "OTP Sent Time", "last_ip", "Sms_api_res", "Created_at", "Updated_at"
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->ax_id,
            $row->iag_code,
            $row->pfu,
            $row->name,
            $row->designation,
            $row->employee_id,
            $row->grade,
            $row->user_type,
            $row->location,
            $row->hq_state,
            $row->territory,
            $row->team,
            $row->telephone_no,
            $row->date_of_joining,
            $row->last_working_date,
            $row->category,
            $row->date_of_birth,
            $row->education_qualification,
            $row->gender,
            $row->marital_status,
            $row->official_email_id,
            $row->personal_email_id,
            $row->uan_number,
            $row->esic_status,
            $row->esic_no,
            $row->compliance_branch,
            $row->department,
            $row->pan,
            $row->aadhar_number,
            '`' . $row->account_number, // Add the backtick to the account number
            $row->address_1,
            $row->address_2,
            $row->address_3,
            $row->address_district,
            $row->address_state,
            $row->address_pin_code,
            $row->beneficiary_name,
            $row->ifsc,
            $row->bank_name,
            $row->branch_name,
            $row->account_base_type,
            $row->transfer_type,
            $row->account_type,
            $row->status,
            $row->otp,
            $row->otp_sent_time,
            $row->last_ip,
            $row->sms_api_response,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
