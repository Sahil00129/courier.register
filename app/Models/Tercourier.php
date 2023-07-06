<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Models\HandoverDetail;
use App\Models\Po;
use App\Models\InvoiceHandoverDetail;
use Helper;


date_default_timezone_set('Asia/Kolkata');

class Tercourier extends Model
{
    use HasFactory;
    protected $table = 'tercouriers';
    protected $fillable = [
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name', 'ax_id', 'employee_id', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks', 'recp_entry_time', 'given_to', 'status', 'created_at', 'updated_at', 'finfect_response', 'refrence_transaction_id',
        'saved_by_id', 'saved_by_name', 'received_date', 'handover_date', 'sent_to_finfect_date', 'paid_date', 'created_at', 'updated_at', 'book_date', 'file_name',
        'po_id', 'basic_amount', 'total_amount', 'invoice_no', 'invoice_date', 'ter_type', 'handover_id', 'verify_ter_date', 'is_rejected',
        'pfu', 'old_unit', 'unit_change_remarks', 'is_unit_changed', 'iag_code', 'shifting_date', 'super_admin_remarks', 'cancel_reject', 'dedcution_paid', 'advance_used', 'deduction_options', 'paylater_uploads', 'paylater_remarks', 'po_value', 'sourcing_remarks',
        'scanning_remarks', 'not_eligible', 'vapi_res', 'copy_status'


    ];

    public function Tercourier()
    {
        return $this->hasOne('App\Models\ChildTercouriers', 'tercourier_id', 'id');
    }

    public function CourierCompany()
    {
        return $this->belongsTo('App\Models\CourierCompany', 'courier_id');
    }

    public function SenderDetail()
    {
        return $this->belongsTo('App\Models\Sender', 'sender_id');
    }
    public function HandoverDetail()
    {
        return $this->hasone('App\Models\HandoverDetail', 'handover_id', 'handover_id');
    }
    public function PoDetail()
    {
        return $this->hasone('App\Models\Po', 'id', 'po_id');
    }

    // Dhruv's Code
    public static function get_details_of_employee($unique_ids, $user_id, $user_name)
    {
        // return $unique_ids;
        $res = DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status', 1)->get();


        // foreach($res as $r){
        //     print_r($r->id);
        //     exit;
        // }

        $ter_team_ids = array();
        $hr_admin_ids = array();
        $sourcing_ids = array();
        $date = "";
        $change['is_rejected'] = 0;

        for ($i = 0; $i < sizeof($res); $i++) {

            if ($res[$i]->ter_type == 1) {
                $change['status'] = 11;

                if ($res[$i]->copy_status == 12) {
                    $change['txn_type'] = 'unknown_invoice';
                    $change['copy_status'] = 12;
                } else {
                    $change['copy_status'] = 2;
                    $change['txn_type'] = "sourcing_regular_invoice";
                }

                $sourcing_ids[] = $res[$i]->id;
                $change['saved_by_id'] = $user_id;
                $change['saved_by_name'] = $user_name;
                $change['handover_date'] = date('Y-m-d');
                $change['delivery_date'] = date('Y-m-d');
                $data =  DB::table('tercouriers')->where('id', $res[$i]->id)->update($change);
            } else {
                $date = date_create($res[$i]->terto_date);
                date_add($date, date_interval_create_from_date_string("50 days"));
                $date_check = date_format($date, "Y-m-d");

                $today_date = date('Y-m-d');
                $change['given_to'] = 'TER-Team';
                if ($today_date <= $date_check) {
                    $change['status'] = 11;
                    $change['copy_status'] = 2;
                    $change['txn_type'] = "regular_ter";
                    if ($res[$i]->employee_id != 0) {
                        $ter_team_ids[] = $res[$i]->id;
                    }
                } else {
                    if ($res[$i]->employee_id != 0) {
                        $ter_team_ids[] = $res[$i]->id;
                        $change['status'] = 11;
                        $change['copy_status'] = 8;
                        $change['txn_type'] = "rejected_ter";
                        $change['given_to'] = 'TER-Team';
                    } else {
                        $change['is_rejected'] = 1;
                    }
                }

                if ($res[$i]->employee_id == 0) {
                    $hr_admin_ids[] = $res[$i]->id;
                    $change['status'] = 11;
                    $change['copy_status'] = 9;
                    $change['given_to'] = 'HR-Team';
                    $change['txn_type'] = "emp_doesn't_exists";
                }

                // if (!empty($res[$i]->last_working_date)) {
                //     $change_status = DB::table('tercouriers')->where("id", $data['unique_id'])->update(array(
                //         'payment_type' => 'full_and_final_payment', 'status' => 4, 'payment_status' => 3, 'book_date' => date('Y-m-d')
                //     ));
                //     return $change_status;
                // }

                $change['saved_by_id'] = $user_id;
                $change['saved_by_name'] = $user_name;
                $change['handover_date'] = date('Y-m-d');
                $change['delivery_date'] = date('Y-m-d');
                // print_r($today_date);
                // print_r($date_check);
                // print_r($change);
                // exit;
                $data =  DB::table('tercouriers')->where('id', $res[$i]->id)->update($change);
                $date = "";
                $change['is_rejected'] = 0;
            }
        }

        $hr = implode(',', $hr_admin_ids);
        $ter = implode(',', $ter_team_ids);
        $sourcing = implode(',', $sourcing_ids);
        $size_sourcing = sizeof($sourcing_ids);
        $size_hr = sizeof($hr_admin_ids);
        $size_ter = sizeof($ter_team_ids);
        $handover_data['created_at'] = date('Y-m-d H:i:s');
        $handover_data['updated_at'] = date('Y-m-d H:i:s');
        if (!empty($ter_team_ids)) {
            $handover_id = HandoverDetail::select('handover_id')->latest('handover_id')->first();
            $handover_id = json_decode(json_encode($handover_id), true);
            if (empty($handover_id) || $handover_id == null) {
                $handover_id = 1000001;
            } else {
                $handover_id = $handover_id['handover_id'] + 1;
            }
            $handover_data['handover_id'] = $handover_id;
            $handover_data['ter_id_count'] = $size_ter;
            $handover_data['ter_ids'] = $ter;
            $handover_data['department'] = 'ter-team';
            $handover_data['reception_action'] = '1';
            $handover_data['doc_type'] = 'ter';
            $handover_data['created_user_id'] = $user_id;
            $res = HandoverDetail::insert($handover_data);
            if ($res) {

                $new_res = DB::table('tercouriers')->whereIn('id', $ter_team_ids)->where('status', 11)->update(array("handover_id" => $handover_id));
            }
        }


        if (!empty($hr_admin_ids)) {
            $handover_id = HandoverDetail::select('handover_id')->latest('handover_id')->first();
            $handover_id = json_decode(json_encode($handover_id), true);
            if (empty($handover_id) || $handover_id == null) {
                $handover_id = 1000001;
            } else {
                $handover_id = $handover_id['handover_id'] + 1;
            }
            $handover_data['handover_id'] = $handover_id;
            $handover_data['ter_id_count'] = $size_hr;
            $handover_data['ter_ids'] = $hr;
            $handover_data['department'] = 'hr-admin';
            $handover_data['reception_action'] = '1';
            $handover_data['doc_type'] = 'ter';
            $handover_data['created_user_id'] = $user_id;
            $res = HandoverDetail::insert($handover_data);
            if ($res) {
                $new_res = DB::table('tercouriers')->whereIn('id', $hr_admin_ids)->where('status', 11)->update(array("handover_id" => $handover_id));
            }
        }

        if (!empty($sourcing_ids)) {
            $handover_id = HandoverDetail::select('handover_id')->latest('handover_id')->first();
            $handover_id = json_decode(json_encode($handover_id), true);
            if (empty($handover_id) || $handover_id == null) {
                $handover_id = 1000001;
            } else {
                $handover_id = $handover_id['handover_id'] + 1;
            }
            $handover_data['handover_id'] = $handover_id;
            $handover_data['ter_id_count'] = $size_sourcing;
            $handover_data['ter_ids'] = $sourcing;
            $handover_data['department'] = 'sourcing-team';
            $handover_data['reception_action'] = '1';
            $handover_data['doc_type'] = 'sourcing';
            $handover_data['created_user_id'] = $user_id;
            $res = HandoverDetail::insert($handover_data);
            if ($res) {

                $new_res = DB::table('tercouriers')->whereIn('id', $sourcing_ids)->where('status', 11)->update(array("handover_id" => $handover_id));
            }
        }
        return $new_res;
    }

    public static function handover_invoice($unique_ids, $user_id, $user_name, $user_type)
    {
        // return $unique_ids;
        if ($user_type == 'sourcing') {
            $res = DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status', 3)->where('ter_type', 1)->get();
            $change['status'] = 4;
            $handover_data['handover_by_department'] = 'sourcing-team';
            $handover_data['handover_to_department'] = 'accounts';
            $handover_data['handover_date'] = date('Y-m-d');
        }

        if ($user_type == 'accounts') {
            $res = DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status', 6)->where('ter_type', 1)->get();
            $change['status'] = 7;
            $handover_data['handover_by_department'] = 'accounts';
            $handover_data['handover_to_department'] = 'scanning';
            $handover_data['acc_handover_date'] = date('Y-m-d');
        }


        $account_ids = array();


        for ($i = 0; $i < sizeof($res); $i++) {

            if ($res[$i]->ter_type == 1) {


                $change['txn_type'] = "sourcing_regular_invoice";
                $account_ids[] = $res[$i]->id;
                $change['saved_by_id'] = $user_id;
                $change['saved_by_name'] = $user_name;
                $change['handover_date'] = date('Y-m-d');
                $change['delivery_date'] = date('Y-m-d');
                $data =  DB::table('tercouriers')->where('id', $res[$i]->id)->update($change);
            }
        }


        $handover_data['created_at'] = date('Y-m-d H:i:s');
        $handover_data['updated_at'] = date('Y-m-d H:i:s');

        $account = implode(',', $account_ids);
        $size_account = sizeof($account_ids);


        if (!empty($account_ids)) {
            $invoice_handover_id = InvoiceHandoverDetail::select('invoice_handover_id')->latest('invoice_handover_id')->first();
            $invoice_handover_id = json_decode(json_encode($invoice_handover_id), true);
            if (empty($invoice_handover_id) || $invoice_handover_id == null) {
                $invoice_handover_id = 10000001;
            } else {
                $invoice_handover_id = $invoice_handover_id['invoice_handover_id'] + 1;
            }
            $handover_data['invoice_handover_id'] = $invoice_handover_id;
            $handover_data['invoice_id_count'] = $size_account;
            $handover_data['unids'] = $account;
            $handover_data['user_action'] = '1';
            $handover_data['created_user_id'] = $user_id;
            $res = InvoiceHandoverDetail::insert($handover_data);
            // if($res)
            // {

            //     $new_res = DB::table('tercouriers')->whereIn('id', $account_ids)->where('status', 11)->update(array("invoice_handover_id" => $invoice_handover_id));

            // }
        }
        return $res;
    }

    public static function add_data($voucher, $amount, $unique_ids, $user_id, $user_name)
    {
        $data['voucher_code'] = $voucher;
        $data['payable_amount'] = $amount;
        $data['status'] = 3;
        $data['saved_by_id'] = $user_id;
        $data['saved_by_name'] = $user_name;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $query =  DB::table('tercouriers')->where('id', $unique_ids)
            ->update($data);
        return $query;
    }

    public static function add_voucher_payable($payable_data, $unique_id, $user_id, $user_name, $payment_status, $final_payable)
    {
        //If Payment_Status = 1 than pay now if Payment_Status = 2 pay later payment_status=3 is full and final,payment_status=4 is advance_payment, payment_status=5 is manually_paid,payment_status=6 deduction_settlement.
        // Status=1 is Received, Status=2 is Handover, Status=3 is Sent to Finfect,For pay later and full & final Status=4 is Pay, Status=0 is Failed Payment,Status=5 is Paid,Status=6 is cancelled ter,Status=7 Partially Paid,Status=8 Rejected TER,Status=9 Emp Doesn't Exists,Ter Status=10 Reject_by_HR, Ter Status=11 Handover_Created,
        // Ter Status=12 is Unit Changed, Ter Status=13 is Rejected_Payment, Ter Status=14 is UNID_GENERATED
        $check_pay_type = DB::table('tercouriers')->select('payment_type')->where('id', $unique_id)->get();
        //    echo "<pre>";
        //    print_r($payment_status);
        //    exit;
        if ($payment_status == 1) {
            $data['status'] = 3;
            if ($check_pay_type[0]->payment_type == "pay_later_payment") {
                $data['payment_type'] = "pay_later_payment";
                $data['sent_to_finfect_date'] = "";
                $data['book_date'] = date('Y-m-d');
            } else if ($check_pay_type[0]->payment_type == "full_and_final_payment") {
                $data['payment_type'] = "full_and_final_payment";
                $data['sent_to_finfect_date'] = "";
                $data['book_date'] = date('Y-m-d');
            }
            $data_ter = DB::table('tercouriers')->where('id', $unique_id)->get()->toArray();
            $id_sender = $data_ter[0]->sender_id;
            $check_last_working = DB::table('sender_details')->where('id', $id_sender)->get()->toArray();

            if (!empty($check_last_working)) {
                if (!empty($check_last_working[0]->last_working_date)) {
                    // $get_last_working_month = explode("-", $check_last_working[0]->last_working_date);
                    $check_ter_month = Helper::ShowFormatDate($data_ter[0]->terto_date);

                    if (strtotime($check_last_working[0]->last_working_date) > strtotime($check_ter_month)) {
                        $data['payment_type'] = "full_and_final_payment";
                        $payment_status = 3;
                        $data['sent_to_finfect_date'] = "";
                        $data['book_date'] = date('Y-m-d');
                    } else {
                        $data['payment_type'] = "regular_payment";
                        $data['sent_to_finfect_date'] = date('Y-m-d');
                        $data['book_date'] = date('Y-m-d');
                    }
                }
            } else {
                $data['payment_type'] = "regular_payment";
                $data['sent_to_finfect_date'] = date('Y-m-d');
                $data['book_date'] = date('Y-m-d');
            }
        } else if ($payment_status == 2) {
            $data['status'] = 4;
            $data['sent_to_finfect_date'] = "";
            $data['book_date'] = date('Y-m-d');
            $data_ter = DB::table('tercouriers')->where('id', $unique_id)->get()->toArray();
            //         echo "<pre>";
            //    print_r($data_ter[0]);
            //    exit;
            $id_sender = $data_ter[0]->sender_id;
            $check_last_working = DB::table('sender_details')->where('id', $id_sender)->get()->toArray();

            if (!empty($check_last_working)) {
                if (!empty($check_last_working[0]->last_working_date)) {
                    // $get_last_working_month = explode("-", $check_last_working[0]->last_working_date);
                    $check_ter_month = Helper::ShowFormatDate($data_ter[0]->terto_date);

                    if (strtotime($check_last_working[0]->last_working_date) > strtotime($check_ter_month)) {
                        $data['payment_type'] = "full_and_final_payment";
                        $payment_status = 3;
                        $data['sent_to_finfect_date'] = "";
                        $data['book_date'] = date('Y-m-d');
                    } else {
                        $data['payment_type'] = "pay_later_payment";
                        $data['sent_to_finfect_date'] = "";
                        $data['book_date'] = date('Y-m-d');
                    }
                }
            } else {
                $data['payment_type'] = "pay_later_payment";
                $data['sent_to_finfect_date'] = "";
                $data['book_date'] = date('Y-m-d');
            }
        } else if ($payment_status == 4) {
            $data['status'] = 5;
            $data['payment_type'] = "advance_payment";
            $data['paid_date'] = date('Y-m-d');
            $data['sent_to_finfect_date'] = "";
            $data['book_date'] = date('Y-m-d');
        }

        // $data['payment_status'] = $payment_status;
        $data['final_payable'] = $final_payable;
        $data['updated_by_id'] = $user_id;
        $data['updated_by_name'] = $user_name;
        $data['updated_at'] = date('Y-m-d H:i:s');


        if (!empty($payable_data)) {

            $data['payment_status'] = $payment_status;
            $length = sizeof($payable_data);
            for ($i = 0; $i < $length; $i++) {
                $pay_data[$i] = $payable_data[$i]['payable_amount'];
                $voucher_data[$i] = $payable_data[$i]['voucher_code'];
            }

            $data['payable_amount'] = $pay_data;
            $data['voucher_code'] = $voucher_data;
        }
        $data['verify_ter_date'] = date('Y-m-d');
        // return $data;
        $query =  DB::table('tercouriers')->where('id', $unique_id)
            ->update($data);

        return $query;
    }

    public static function add_multiple_data($voucher, $amount, $unique_ids, $user_id, $user_name)
    {

        $data['voucher_code'] = $voucher;
        $data['payable_amount'] = $amount;
        $data['id'] = $unique_ids;

        // $checkquery=DB::table('tercouriers')->select('amount','id')->whereIn('id',$unique_ids)->get()->toArray();
        // return $checkquery;

        foreach ($data['id'] as $key => $newdata) {
            $payable_amount = $data['payable_amount'][$key];
            $coupon = $data['voucher_code'][$key];
            $id = $newdata;
            $checkquery = DB::table('tercouriers')->select('amount', 'id')->where('id', $id)->get();


            if ($checkquery[0]->amount > $payable_amount) {
                $query = DB::table('tercouriers')->where('id', $id)->update(array(
                    'payable_amount' => $payable_amount, 'voucher_code' => $coupon,
                    'status' => 3, 'saved_by_id' => $user_id, 'saved_by_name' => $user_name, 'updated_at' => date('Y-m-d H:i:s')
                ));
            } else {
                return 0;
            }
        }

        return $query;
    }
}
