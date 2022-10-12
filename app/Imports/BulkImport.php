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
                    'hq_state' => $row['hq_state'],
                    'territory' => $row['territory'],
                    'team' => $row['team'],
                    'date_of_joining' => $row['date_of_joining'],
                    'category' => $row['category'],
                    'date_of_birth' => $row['date_of_birth'],
                    'education_qualification' => $row['education_qualification'],
                    'gender' => $row['gender'],
                    'marital_status' => $row['marital_status'],
                    'official_email_id' => $row['official_email_id'],
                    'personal_email_id' => $row['personal_email_id'],
                    'uan_number' => $row['uan_no'],
                    'esic_status' => $row['esic_status'],
                    'esic_no' => $row['esic_no'],
                    'compliance_branch' => $row['compliance_branch'],
                    'department' => $row['department'],
                    'pan' => $row['pan'],
                    'aadhar_number' => $row['aadhar_number'],
                    'account_number' => $row['account_number'],
                    'ifsc' => $row['ifsc_code'],
                    'bank_name' => $row['bank_name'],
                    'branch_name' => $row['branch_name'],
                    'address_1' => $row['address_1'],
                    'address_2' => $row['address_2'],
                    'address_3' => $row['address_3'],
                    'address_district' => $row['address_district'],
                    'address_state' => $row['address_state'],
                    'address_pin_code' => $row['address_pin_code'],
                    'beneficiary_name'=>$row['beneficiary_name'],
                    'account_base_type'=>$row['account_base_type'],
                    'transfer_type'=>$row['transfer_type'],
                    'account_type'=>$row['type']

                ]);
            }else{
            // print_r("Dsd");
                // return "Data is already added";
            }


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

            if ($sender_table->location != $row['hq']) {
                // print_r($sender_table->last_working_date);
                $location_update = Sender::where('id', $sender_table->id)->update(['location' => $row['hq']]);

            }

            if ($sender_table->telephone_no != $row['mobile_no']) {
                // print_r($sender_table->last_working_date);
                $mobile_no_update = Sender::where('id', $sender_table->id)->update(['telephone_no' => $row['mobile_no']]);

            }


            // print_r($lastworkingdate);
            // exit;
            if (!empty($lastworkingdate)) {
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
                    else if(strtotime($sender_table->last_working_date) > strtotime($lastworkingdate) ) {
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
                        $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $final_exit_date, 'status' => 'Active']);
                        $updated_details['updated_field'] = 'Date of Leaving has been Added as ' . $final_exit_date;
                        if ($date_of_leaving_update) {
                            $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                            // echo "<pre>";
                            // print_r($updated_record_detail);
                        }
                    } else {
                        $updated_details['updated_id'] = $sender_table->id;
                        $table_date = strtotime($sender_table->last_working_date);
                        if ($exit_date != $table_date) {
                            $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => $final_exit_date, 'status' => 'Active']);
                            $updated_details['updated_field'] = 'Date of Leaving has been changed from ' . $sender_table->last_working_date . ' to ' . $final_exit_date;
                            if ($date_of_leaving_update) {
                                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                                // echo "<pre>";
                                // print_r($updated_record_detail);
                            }
                        }
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
            $get_data_ter_courier=DB::table('tercouriers')->where('id',$row['un_id'])->get()->toArray();
            if(!empty($get_data_ter_courier)){
            if($row['un_id'] == $get_data_ter_courier[0]->id)
            {
                // echo "<pre>";
                // print_r($row['un_id']." = " );
                // print_r($get_data_ter_courier[0]->id." " );
                // print_r($row['old_sender_id']." = " );
                // print_r($get_data_ter_courier[0]->sender_id." Changed to ");
                // print_r($row['new_sender_id']);
                $updated_data=DB::table('tercouriers')->where('id',$row['un_id'])->update(['sender_name'=>$row['sender_name'],'ax_id'=>$row['ax_id'],'employee_id'=>$row['employee_id']]);
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
    }
}
