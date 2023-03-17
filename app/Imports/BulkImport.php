<?php

namespace App\Imports;

use DB;
use App\Models\Sender;
use App\Models\CourierCompany;
use App\Models\Category;
use App\Models\ForCompany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
date_default_timezone_set('Asia/Kolkata');

class BulkImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    // public function toArray(){

    // }
    public function model(array $row)
    {
        
        if($_POST['import_type'] == 1){
            
            //  $lastworkingdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['last_working_date']);
              //  $lastworkingdate = $row['last_working_date']->format('d-m-Y');
              if(!empty($row['last_working_date'])){
            $month_number=explode("-",$row['last_working_date']);
            switch ($month_number[1]) {
                case "Jan":
                    $month_number[1]='01';
                  break;
                case "Feb":
                    $month_number[1]='02';
                  break;
                case "Mar":
                    $month_number[1]='03';
                  break;
                case "Apr":
                    $month_number[1]='04';
                  break;
                case "May":
                    $month_number[1]='05';
                  break;
                case "Jun":
                    $month_number[1]='06';
                case "Jul":
                    $month_number[1]='07';
                  break;
                case "Aug":
                  $month_number[1]='08';
                  break;
                case "Sep":
                    $month_number[1]='09';
                  break;
                case "Oct":
                    $month_number[1]='10';
                  break;
                case "Nov":
                    $month_number[1]='11';
                  break;
                case "Dec":
                    $month_number[1]='12';
                  break;
              }
            $final_exit_date=$month_number[0].'-'.$month_number[1].'-'.$month_number[2];
              }else{
                $final_exit_date = NULL;
              }
           
            $sender = DB::table('sender_details')
                ->where('ax_id', '=', $row['ax_id'])
                ->first();
               
            if(empty($sender)) { 
                if($row['type'] == 'Employee'){
                    return new Sender([
                        'ax_id' => $row['ax_id'],
                        'name'  => $row['name'],
                        'employee_id' => $row['employee_id'],
                        'type'    => $row['type'],
                        'location' => $row['location'],
                        'telephone_no' => (float)$row['telephone_no'],
                        'status' => $row['status'],
                         'last_working_date' => $final_exit_date,
                    ]);
                }
            } else {
                DB::table('sender_details')
                    ->where('ax_id', $row['ax_id'])->update(['status' => $row['status']]);
            }
        }

        if ($_POST['import_type'] == 2) {
            //echo "<pre>"; print_r($row);die;
            $CU = DB::table('courier_companies')
                ->where('courier_name', '=', $row['courier_name'])
                ->first();

            if (is_null($CU)) {
                return new CourierCompany([
                    'courier_name'  => $row['courier_name'],
                    'phone'  => $row['phone'],
                ]);
            }
        }

        if ($_POST['import_type'] == 3) {
            //echo "<pre>"; print_r($row['department']);die;
            $catagory = DB::table('catagories')
                ->where('catagories', '=', $row['catagories'])
                ->first();
            if (is_null($catagory)) {
                return new Category([
                    'catagories'  => $row['catagories']
                ]);
            }
        }
        if ($_POST['import_type'] == 4) {
            //echo "<pre>"; print_r($row['department']);die;
            $for = DB::table('for_companies')
                ->where('for_company', '=', $row['for_company'])
                ->first();
            if (is_null($for)) {
                return new ForCompany([
                    'for_company'  => $row['for_company']
                ]);
            }
        }

        if ($_POST['import_type'] == 5) {

            if(!empty($row['employee_code'])){
            $sender_table = DB::table('sender_details')
                ->where('employee_id', '=', $row['employee_code'])
                ->orderBy('created_at', 'DESC')->first();
            // echo'<pre>';print_r($row);
            // echo'<pre>';print_r($sender_table);
            }
//    echo'<pre>';print_r($row);
            // echo'<pre>';print_r($sender_table);

            $details = Auth::user();
            $updated_details['user_id'] = $details->id;
            $updated_details['user_name'] = $details->name;
            $updated_details['date'] = date('Y-m-d');
            $updated_details['created_at'] = date('Y-m-d H:i:s');
            $updated_details['updated_at'] = date('Y-m-d H:i:s');


            if (!empty($row['date_of_leaving'])) {
                if (is_numeric($row['date_of_leaving'])) {

                    $lastworkingdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_leaving']);
                    $lastworkingdate = $lastworkingdate->format('d-m-Y');
                } else {
                    $lastworkingdate = $row['date_of_leaving'];
                }
            } else {
                $lastworkingdate = "";
            }

            // echo'<pre>';print_r($lastworkingdate);

              $pfu="";
          if($row['grade'] == "Unit - 1")
            {
                $pfu="SD1";
            } else if($row['grade'] == "Unit - 2")
            {
                $pfu="MA2";
            } else if($row['grade'] == "Unit - 3")
            {
                $pfu="SD3";
            }
            else if($row['grade'] == "Unit - 4")
            {
                $pfu="MA4";
            }

            if (empty($sender_table)) {
// print_r("Dd");
                $today = date('d-m-Y');
                $exit_date = strtotime($lastworkingdate);
                $today_date = strtotime($today);

                if ($exit_date < $today_date) {
                    $status = "Blocked";
                } else {
                    $status = "Active";
                }
                if (empty($row['date_of_leaving'])) {
                    $status = "Active";
                }

                return new Sender([
                    'ax_id' => $row['ax_code'],
                    'name' => $row['employee_name'],
                    'employee_id' => $row['employee_code'],
                    'type' => 'Employee',
                    'location' => $row['hq'],
                    'telephone_no' => $row['mobile_no'],
                    'last_working_date' => $lastworkingdate,
                    'status' => $status,
                    'grade' => $row['grade'],
                    'designation' => $row['designation'],
                    // 'hq_state' => $row['hq_state'],
                    'territory' => $row['territory'],
                    // 'team' => $row['team'],
                    'date_of_joining' => $row['date_of_joining'],
                    // 'category' => $row['category'],
                    'date_of_birth' => $row['date_of_birth'],
                    // 'education_qualification' => $row['education_qualification'],
                    // 'gender' => $row['gender'],
                    // 'marital_status' => $row['marital_status'],
                    'official_email_id' => $row['official_email_id'],
                    // 'personal_email_id' => $row['personal_email_id'],
                    // 'uan_number' => $row['uan_no'],
                    // 'esic_status' => $row['esic_status'],
                    // 'esic_no' => $row['esic_no'],
                    // 'compliance_branch' => $row['compliance_branch'],
                    // 'department' => $row['department'],
                    'pan' => $row['pan'],
                    'aadhar_number' => $row['aadhar_number'],
                    'account_number' => $row['account_number'],
                    'ifsc' => $row['ifsc_code'],
                    'bank_name' => $row['bank_name'],
                    'branch_name' => $row['branch_name'],
                    // 'address_1' => $row['address_1'],
                    // 'address_2' => $row['address_2'],
                    // 'address_3' => $row['address_3'],
                    // 'address_district' => $row['address_district'],
                    // 'address_state' => $row['address_state'],
                    // 'address_pin_code' => $row['address_pin_code'],
                    'beneficiary_name'=>$row['beneficiary_name'],
                    // 'account_base_type'=>$row['account_base_type'],
                    // 'transfer_type'=>$row['transfer_type'],
                    // 'account_type'=>$row['type'],
                    'iag_code'=>$row['iag_code'],
                    'pfu'=>$pfu

                ]);
            }

            // 'account_number' => $row['account_number'],
            // 'ifsc' => $row['ifsc_code'],
            // 'bank_name' => $row['bank_name'],


            if ($sender_table->ax_id != $row['ax_code']) {
                // print_r($sender_table->last_working_date);
                $updated_details['updated_id'] = $sender_table->id;
                $ax_code_update = Sender::where('id', $sender_table->id)->update(['ax_id' => $row['ax_code']]);

                $updated_details['updated_field'] = 'AX CODE  Changed from ' . $sender_table->ax_id . ' to ' . $row['ax_code'];

                if ($ax_code_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";print_r($updated_record_detail);
                }
            }

            if ($sender_table->account_number != $row['account_number']) {
                // print_r($sender_table->last_working_date);
                $updated_details['updated_id'] = $sender_table->id;
                $account_number_update = Sender::where('id', $sender_table->id)->update(['account_number' => $row['account_number']]);

                $updated_details['updated_field'] = 'Account Number  Changed from ' . $sender_table->account_number . ' to ' . $row['account_number'];

                if ($account_number_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";print_r($updated_record_detail);
                }
            }

            // print_r(($row['beneficiary_name']));
            // print_r($sender_table->beneficiary_name);
            // exit;

            if ($sender_table->beneficiary_name != $row['beneficiary_name']) {
                // print_r($sender_table->last_working_date);
                $updated_details['updated_id'] = $sender_table->id;
                $ifsc_code_update = Sender::where('id', $sender_table->id)->update(['beneficiary_name' => $row['beneficiary_name']]);

                $updated_details['updated_field'] = 'Beneficiary Name  Changed from ' . $sender_table->beneficiary_name . ' to ' . $row['beneficiary_name'];

                if ($ifsc_code_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";print_r($updated_record_detail);
                }
            }

            if ($sender_table->ifsc != $row['ifsc_code']) {
                // print_r($sender_table->last_working_date);
                $updated_details['updated_id'] = $sender_table->id;
                $ifsc_code_update = Sender::where('id', $sender_table->id)->update(['ifsc' => $row['ifsc_code']]);

                $updated_details['updated_field'] = 'IFSC Code Changed from ' . $sender_table->ifsc . ' to ' . $row['ifsc_code'];

                if ($ifsc_code_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";print_r($updated_record_detail);
                }
            }

            if ($sender_table->bank_name != $row['bank_name']) {
                // print_r($sender_table->last_working_date);
                $updated_details['updated_id'] = $sender_table->id;
                $bank_name_update = Sender::where('id', $sender_table->id)->update(['bank_name' => $row['bank_name']]);

                $updated_details['updated_field'] = 'Bank Name Changed from ' . $sender_table->bank_name . ' to ' . $row['bank_name'];

                if ($bank_name_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";print_r($updated_record_detail);
                }
            }

            if ($sender_table->iag_code != $row['iag_code']) {
                // print_r($sender_table->last_working_date);
                Sender::where('id', $sender_table->id)->update(['iag_code' => $row['iag_code']]);

            }

            
            if ($sender_table->designation != $row['designation']) {
                // print_r($sender_table->last_working_date);
                Sender::where('id', $sender_table->id)->update(['designation' => $row['designation']]);

            }

            if ($sender_table->grade != $row['grade']) {
                // print_r($sender_table->last_working_date);
                Sender::where('id', $sender_table->id)->update(['grade' => $row['grade']]);

            }
            
            if ($sender_table->pfu != $pfu) {
                // print_r($sender_table->last_working_date);
               Sender::where('id', $sender_table->id)->update(['pfu' => $pfu]);

            }

            if ($sender_table->location != $row['hq']) {
                // print_r($sender_table->last_working_date);
                $location_update = Sender::where('id', $sender_table->id)->update(['location' => $row['hq']]);

            }

            if ($sender_table->telephone_no != $row['mobile_no']) {
                // print_r($sender_table->last_working_date);
                $mobile_no_update = Sender::where('id', $sender_table->id)->update(['telephone_no' => $row['mobile_no']]);

            }

            if ($sender_table->official_email_id != $row['official_email_id']) {
                // print_r($sender_table->last_working_date);
                $mobile_no_update = Sender::where('id', $sender_table->id)->update(['official_email_id' => $row['official_email_id']]);

            }

            

            // echo "<pre>";
            // print_r($row['employee_code']);
            // exit;
            if(empty($row['date_of_leaving']) && !empty($sender_table->last_working_date))
            {
                    $updated_details['updated_id'] = $sender_table->id;
                    $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => "", 'status' => 'Active']);
                    $updated_details['updated_field'] = 'Date of Leaving has been Removed as ' . $sender_table->last_working_date;
                    if ($date_of_leaving_update) {
                        $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                        // echo "<pre>";
                        // print_r($updated_record_detail);
                    }
                
            }
            else{
        

            if (!empty($lastworkingdate) || $row['date_of_leaving']!=$sender_table->last_working_date) {
       
                $month_number = explode("-", $lastworkingdate);

                switch ($month_number[1]) {
                    case "Jan":
                        $month_number[1] = '01';
                        break;
                    case "Feb":
                        $month_number[1] = '02';
                        break;
                    case "Mar":
                        $month_number[1] = '03';
                        break;
                    case "Apr":
                        $month_number[1] = '04';
                        break;
                    case "May":
                        $month_number[1] = '05';
                        break;
                    case "Jun":
                        $month_number[1] = '06';
                    case "Jul":
                        $month_number[1] = '07';
                        break;
                    case "Aug":
                        $month_number[1] = '08';
                        break;
                    case "Sep":
                        $month_number[1] = '09';
                        break;
                    case "Oct":
                        $month_number[1] = '10';
                        break;
                    case "Nov":
                        $month_number[1] = '11';
                        break;
                    case "Dec":
                        $month_number[1] = '12';
                        break;
                }
                $final_exit_date = $month_number[0] . '-' . $month_number[1] . '-' . $month_number[2];
                $today = date('d-m-Y');
                $exit_date = strtotime($final_exit_date);
                $today_date = strtotime($today);
    
                // print_r($sender_table->last_working_date);
                if ($exit_date < $today_date) {
            
                    if (empty($sender_table->last_working_date)) {
                        $updated_details['updated_id'] = $sender_table->id;
                        $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
                        $updated_details['updated_field'] = 'Date of Leaving has been Added as ' . $lastworkingdate;
                        if ($date_of_leaving_update) {
                            $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                            // echo "<pre>";
                            // print_r($updated_record_detail);
                        }
                    } 
                    else if(strtotime($sender_table->last_working_date) >= strtotime($lastworkingdate) ) {
                        // echo "<pre>";
                        // print_r($lastworkingdate."  ");
                        // print_r("Sender Table Entry  ");
                        // print_r($sender_table->id."  ");
                        // print_r($sender_table->last_working_date);
                        // echo "<pre>";
                        //         // print_r($lastworkingdate);
                        //         print_r($sender_table->id);
                        //         print_r($sender_table->last_working_date);
                        $updated_details['updated_id'] = $sender_table->id;
                        $table_date = strtotime($sender_table->last_working_date);
                        if ($lastworkingdate != $sender_table->last_working_date) {

                            // print_r($lastworkingdate);
                            $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
                            $updated_details['updated_field'] = 'Date of Leaving has been changed from ' . $sender_table->last_working_date . ' to ' . $lastworkingdate;
                            if ($date_of_leaving_update) {
                                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                                // echo "<pre>";
                                // print_r($updated_record_detail);
                            }
                        }
                    }
                 
                } else {
                    // echo "<pre>";print_r($final_exit_date);

                    if (empty($sender_table->last_working_date)) {
                        $updated_details['updated_id'] = $sender_table->id;
                        $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $row['date_of_leaving'], 'status' => 'Active']);
                        $updated_details['updated_field'] = 'Date of Leaving has been Added as ' . $final_exit_date;
                        if ($date_of_leaving_update) {
                            $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                            // echo "<pre>";
                            // print_r($updated_record_detail);
                        }
                    } 
                    else {
                      
                        $updated_details['updated_id'] = $sender_table->id;
                        $table_date = strtotime($sender_table->last_working_date);
                        if ($exit_date != $table_date) {
                            $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $row['date_of_leaving'], 'status' => 'Active']);
                            $updated_details['updated_field'] = 'Date of Leaving has been changed from ' . $sender_table->last_working_date . ' to ' . $final_exit_date;
                            if ($date_of_leaving_update) {
                                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                                // echo "<pre>";
                                // print_r($updated_record_detail);
                            }
                        }
                    }
                }
            }else{

                $updated_details['updated_id'] = $sender_table->id;
                $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => "", 'status' => 'Active']);
                $updated_details['updated_field'] = 'Date of Leaving has been Removed as ' . $sender_table->last_working_date;
                if ($date_of_leaving_update) {
                    $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                    // echo "<pre>";
                    // print_r($updated_record_detail);
                }
            }
        }

    }
    
        if ($_POST['import_type'] == 6) {
            // echo "<pre>"; print_r($row);
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['un_id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            // echo "<pre>";
            // print_r($get_data_ter_courier[0]->sender_id);
            if($row['un_id'] == $get_data_ter_courier[0]->id)
            {
                // echo "<pre>";
                // print_r($row['un_id']." = " );
                // print_r($get_data_ter_courier[0]->id." " );
                // print_r($row['old_sender_id']." = " );
                // print_r($get_data_ter_courier[0]->sender_id." Changed to ");
                // print_r($row['new_sender_id']);
                $update_sender_id=DB::table('tercouriers')->where('id',$row['un_id'])->update(['sender_id'=>$row['new_sender_id']]);
                print_r($update_sender_id);
            }
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }
        if ($_POST['import_type'] == 7) {
            // echo "<pre>"; print_r($row);
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['id'] == $get_data_ter_courier[0]->id)
            {
               $emp_id=$get_data_ter_courier[0]->employee_id;
               $get_sender_data=Sender::where('employee_id',$emp_id)->get();
              
               $ax_id=$get_sender_data[0]->ax_id;
               $iag_code=$get_sender_data[0]->iag_code;
               $pfu=$get_sender_data[0]->pfu;
                // $updated_data=DB::table('tercouriers')->where('id',$row['id'])->update(['ax_id'=>$ax_id,'iag_code'=>$iag_code,'pfu'=>$pfu]);
                $updated_data=DB::table('tercouriers')->where('id',$row['id'])->update(['pfu'=>$pfu]);

                print_r($updated_data);
                
            }
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }

        if ($_POST['import_type'] == 8) {
            // echo "<pre>"; print_r($row);
            $get_data_ter_courier=DB::table('sender_details')->where('employee_id',$row['employee_code'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['employee_code'] == $get_data_ter_courier[0]->employee_id)
            {
                $updated_data=DB::table('sender_details')->where('employee_id',$row['employee_code'])->update(['beneficiary_name'=>$row['beneficiary_name'],             'account_base_type'=>$row['account_base_type'],'transfer_type'=>$row['transfer_type'],'account_type'=>$row['type']]);
                // print_r($updated_data);
            }
            print_r("Done");
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }

        if ($_POST['import_type'] == 9) {
            // echo "<pre>"; print_r($row);exit;
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['id'] == $get_data_ter_courier[0]->id)
            {
                $updated_data=DB::table('tercouriers')->where('id',$row['id'])->update(['hr_admin_remark'=>'manually paid','status' => '5','payment_status'=>'5','payment_type'=>'manually_paid_payment']);
                // print_r($updated_data);
            }
            print_r("Done");
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }
        if ($_POST['import_type'] == 10) {
            // echo "<pre>"; print_r($row);exit;
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['id'] == $get_data_ter_courier[0]->id)
            {
                $updated_data=DB::table('tercouriers')->where('id',$row['id'])->update(['hr_admin_remark'=>'manually paid','status' => '5','payment_status'=>'5','payment_type'=>'manually_paid_payment']);
                // print_r($updated_data);
            }
            print_r("Done");
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }
        if ($_POST['import_type'] == 11) {
            // echo "<pre>"; print_r($row);exit;
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['id'] == $get_data_ter_courier[0]->id)
            {
               if(strlen($get_data_ter_courier[0]->employee_id) != 5)
               {
                // echo "<pre>";
                if(strlen($row['employee_id'])== 4)
                {
                    $row['employee_id']='0'.$row['employee_id'];
                }
                else if(strlen($row['employee_id'])== 3)
                {
                    $row['employee_id']='00'.$row['employee_id'];
                }
                else if(strlen($row['employee_id'])== 2)
                {
                    $row['employee_id']='000'.$row['employee_id'];
                }
                // print_r($row['employee_id']);
                // exit;
                $updated_data=DB::table('tercouriers')->where('id',$row['id'])->update(['employee_id'=>$row['employee_id'],'updated_at' => date('Y-m-d H:i:s')]);
                // return $updated_data;
               }
                // print_r($get_data_ter_courier[0]->employee_id);
                // print_r($row['employee_id']);
                // exit;
              
                // print_r($updated_data);
            }
            print_r("Done");
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }
        if ($_POST['import_type'] == 12) {
            // echo "<pre>"; print_r($row['employee_code']);exit;
            $get_employee_data=DB::table('sender_details')->where('employee_id',$row['emp_id'])->get()->toArray();
            if(!empty($get_employee_data)){
            if($row['emp_id'] == $get_employee_data[0]->employee_id)
            {
                // $updated_data=DB::table('sender_details')->where('employee_id',$row['emp_id'])->update(['iag_code'=>$row['iag_code'],
                // 'pfu'=>$row['pfu'],'updated_at' => date('Y-m-d H:i:s')]);
                // return $updated_data;
               
                $updated_data=DB::table('sender_details')->where('employee_id',$row['emp_id'])->delete();
                // print_r($get_employee_data[0]->employee_id);
                // print_r($row['employee_id']);
                // exit;
              
                // print_r($updated_data);
            }
            print_r("Done");
            // $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $lastworkingdate, 'status' => 'Blocked']);
            }
            // die;
            // $for = DB::table('for_companies')
            //     ->where('for_company', '=', $row['for_company'])
            //     ->first();
            // if (is_null($for)) {
            //     return new ForCompany([
            //         'for_company'  => $row['for_company']
            //     ]);
            // }
        }
    }
}
