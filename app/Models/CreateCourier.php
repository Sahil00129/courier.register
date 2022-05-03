<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateCourier extends Model
{
    use HasFactory;
    protected $table = 'new_courier_created';
    protected $fillable = [
        'name_company','location','customer_type','docket_no','docket_date','telephone_no','courier_name','catagories','for','distributor_agreement','distributor_name','document_type','distributor_location','remarks_distributor','ledger_for','type_ledger','party_name','year_l','invoice_type','invoice_number','amount_invoice','party_name_invoices','month_invoices','discription_i','bills_type' ,'invoice_number_bills','amount_bills','previouse_reading_b','current_reading_b','for_month_b','bank_name','document_type_cheques' ,'acc_number','for_month_cheques','series','statement_no','amount_imperest','for_month_imprest','discription_legal','company_name_legal','person_name_legal','number_of_pc','discription_pc','company_name_pc','document_number_govt','Discription_govt','DDR_type','number_of_DDR','party_name_ddr','physical_stock_report','discription_physical','month_physical','discription_affidavits','company_name_affidavits','discription_it','other_last','given_to','checked_by','remarks','receipt_date','created_at','updated_at'
    ];

}
