<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BulkImport;
use App\Exports\ExportEmployee;
use App\Exports\ExportTerReport;
use App\Exports\ExportTerTimeline;
use App\Exports\ExportTerCancel;
use App\Exports\ExportTerUpdates;
use App\Exports\ExportTerUserWise;
use App\Exports\ExportTerEmpLedger;
use Response;
use DB;
use App\Models\Sender;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Kolkata');

class ImportExportController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:admin_import_permission', ['only' => ['ImportExcel']]);
    }

    public function ImportExcel()
    {
        return view('pages.import-data');
    }

    public function Import()
    {
        if ($_POST['import_type'] == 1) {
            try {
                $type = $_POST['import_type'];
                //echo'<pre>'; print_r($_FILES); die;
                $data = Excel::import(new BulkImport, request()->file('file'));
                $response['success'] = true;
                $response['import_type'] = $type;
                $response['messages'] = 'Succesfully imported';
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong';
                // echo'<pre>'; print_r($e); die;
                return Response::json($e);
            }
        } elseif ($_POST['import_type'] == 2) {
            //echo '<pre>'; print_r($_FILES); die;
            try {
                $type = $_POST['import_type'];
                $data = Excel::import(new BulkImport, request()->file('file'));
                $response['success'] = true;
                $response['import_type'] = $type;
                $response['messages'] = 'Succesfully imported';
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong';
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 3) {
            try {
                //echo'<pre>'; print_r($_POST); die;
                $type = $_POST['import_type'];
                $data = Excel::import(new BulkImport, request()->file('file'));
                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong';
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 4) {
            try {
                //echo'<pre>'; print_r($_POST); die;
                $type = $_POST['import_type'];
                $data = Excel::import(new BulkImport, request()->file('file'));
                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong';
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 5) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                if ($response['success']) {
                    $pfu_change = self::check_unit_pfu_change();
                }
                if ($pfu_change) {
                    $response['messages'] = 'Succesfully imported';
                    $response['import_type'] = $type;
                    return Response::json($response);
                }
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 6) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 7) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 8) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 9) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 10) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 11) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));

                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 12) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));
                // exit;
                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        } elseif ($_POST['import_type'] == 14) {
            try {
                // echo'<pre>'; print_r($rows); die;
                // $rows = Excel::toArray(new BulkImport, request()->file('file'));
                // return response()->json(["rows"=>$rows]);
                $type = $_POST['import_type'];
                $rows = Excel::toArray(new BulkImport, request()->file('file'));
                Excel::import(new BulkImport, request()->file('file'));
                // exit;
                $response['success'] = true;
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong' . $e;
                return Response::json($response);
            }
        }
    }

    public static function check_unit_pfu_change()
    {
        $get_handover_unid = DB::table('tercouriers')->where('ter_type', 2)->where('status', 2)->whereNull('shifting_date')->get();
        $res = "";
        for ($i = 0; $i < sizeof($get_handover_unid); $i++) {
            $get_emp_id = $get_handover_unid[$i]->employee_id;
            $id = $get_handover_unid[$i]->id;
            $get_sender_data = DB::table('sender_details')->where('employee_id', $get_emp_id)->get();

            //    print_r($get_handover_unid[$i]->iag_code);
            //    print_r($get_sender_data[0]->iag_code);
            //    exit;
            if ($get_handover_unid[$i]->pfu != "") {
                if ($get_handover_unid[$i]->pfu != $get_sender_data[0]->pfu) {
                    $res = DB::table('tercouriers')->where('id', $id)->update([
                        'status' => 12, 'is_unit_changed' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            if ($get_handover_unid[$i]->ax_id != "") {
                if ($get_handover_unid[$i]->ax_id != $get_sender_data[0]->ax_id) {
                    $res = DB::table('tercouriers')->where('id', $id)->update([
                        'status' => 12, 'is_unit_changed' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            if ($get_handover_unid[$i]->iag_code != "") {
                if ($get_handover_unid[$i]->iag_code != $get_sender_data[0]->iag_code) {
                    $res = DB::table('tercouriers')->where('id', $id)->update([
                        'status' => 12, 'is_unit_changed' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            $res = 1;
        }

        return $res;
    }
    public function ExportSender()
    {
        return Excel::download(new ExportEmployee, 'employee_report.xlsx');
    }

    public function ExportSavedEntry()
    {
        return Excel::download(new ExportTerReport, 'tercourier_report.xlsx');
    }

    public function download_report($type)
    {
        //   print_r($type);
        //   exit;
        if ($type == "ter_timeline") {
            return Excel::download(new ExportTerTimeline, 'tertimeline_report.xlsx');
        } else if ($type == "ter_cancel") {
            return Excel::download(new ExportTerCancel, 'ter_cancel_report.xlsx');
            // return Excel::download(new ExportTerReport, 'tercourier_report.xlsx');
        } else if ($type == "ter_updates") {
            return Excel::download(new ExportTerUpdates, 'ter_updates_report.xlsx');
        } else if ($type == "ter_user_wise") {
            return Excel::download(new ExportTerUserWise, 'ter_user_wise_report.xlsx');
        } else if ($type == "emp_ledger") {
            return Excel::download(new ExportTerEmpLedger, 'ter_emp_ledger_report.xlsx');
        } else if ($type == "emp_list") {
            return Excel::download(new ExportEmployee, 'employee_report.xlsx');
        }
    }

    public function update_user_from_spine()
    {




        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://edatakart.com/api/employees',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-API-KEY: FiVGwokXDsJ5MEQrA2JY4e1RXJ7i5EkT'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);



        $res = json_decode($response);

        $size = sizeof($res->data);
        $data = array();
        echo "<pre>";
        print_r($res->data[0]);
        exit;
        for ($i = 0; $i < $size; $i++) {
        

        if (!empty($res->data[$i]->EmployeeCode)) {
            $sender_table = DB::table('sender_details')
                ->where('employee_id', '=', $res->data[$i]->EmployeeCode)
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

        $lastworkingdate="";
        if (!empty($res->data[$i]->LastWorkingDate)) {
                $lastworking = $res->data[$i]->LastWorkingDate;
                $month_number = explode("-", $lastworking);

                switch ($month_number[1]) {
                    case "01":
                        $month_number[1] = 'Jan';
                        break;
                    case "02":
                        $month_number[1] = 'Feb';
                        break;
                    case "03":
                        $month_number[1] = 'Mar';
                        break;
                    case "04":
                        $month_number[1] = 'Apr';
                        break;
                    case "05":
                        $month_number[1] = 'May';
                        break;
                    case "06":
                        $month_number[1] = 'Jun';
                    case "07":
                        $month_number[1] = 'Jul';
                        break;
                    case "08":
                        $month_number[1] = 'Aug';
                        break;
                    case "09":
                        $month_number[1] = 'Sep';
                        break;
                    case "10":
                        $month_number[1] = 'Oct';
                        break;
                    case "11":
                        $month_number[1] = 'Nov';
                        break;
                    case "12":
                        $month_number[1] = 'Dec';
                        break;
                }
                $lastworkingdate = $month_number[2] . '-' . $month_number[1] . '-' . $month_number[0];
        }
        // echo'<pre>';print_r($lastworkingdate);exit;

        $pfu = "";
        if ($res->data[$i]->Grade == "Unit - 1") {
            $pfu = "SD1";
        } else if ($res->data[$i]->Grade == "Unit - 2") {
            $pfu = "MA2";
        } else if ($res->data[$i]->Grade == "Unit - 3") {
            $pfu = "SD3";
        } else if ($res->data[$i]->Grade == "Unit - 4") {
            $pfu = "MA4";
        }

        if (empty($sender_table)) {
        
                if ($res->data[$i]->EmployeeStatus == "E") {
                    $status = "Blocked";
                } else {
                    $status = "Active";
                }

            return new Sender([
                'ax_id' => $res->data[$i]->EmployeeStatus,
                'name' => $res->data[$i]->Name,
                'employee_id' => $res->data[$i]->EmployeeCode,
                'type' => 'Employee',
                'location' => $res->data[$i]->Location,
                'telephone_no' => $res->data[$i]->Mobile1,
                'last_working_date' => $lastworkingdate,
                'status' => $status,
                'grade' => $res->data[$i]->Grade,
                'designation' => $res->data[$i]->Designation,
                // 'hq_state' => $res->data[$i]->EmployeeStatus,
                'territory' => $res->data[$i]->EmployeeStatus,
                // 'team' => $res->data[$i]->EmployeeStatus,
                'date_of_joining' => $res->data[$i]->DateOfJoining,
                // 'category' => $res->data[$i]->EmployeeStatus,
                'date_of_birth' => $res->data[$i]->DateOfBirth,
                // 'education_qualification' => $res->data[$i]->EmployeeStatus,
                // 'gender' => $res->data[$i]->EmployeeStatus,
                // 'marital_status' => $res->data[$i]->EmployeeStatus,
                'official_email_id' => $res->data[$i]->OfficeEmail,
                // 'personal_email_id' => $res->data[$i]->EmployeeStatus,
                // 'uan_number' => $res->data[$i]->EmployeeStatus,
                // 'esic_status' => $res->data[$i]->EmployeeStatus,
                // 'esic_no' => $res->data[$i]->EmployeeStatus,
                // 'compliance_branch' => $res->data[$i]->EmployeeStatus,
                // 'department' => $res->data[$i]->EmployeeStatus,
                'pan' => $res->data[$i]->PanNumber,
                'aadhar_number' => $res->data[$i]->AadharCard,
                'account_number' => $res->data[$i]->AccountNo,
                'ifsc' => $res->data[$i]->IFSCCode,
                'bank_name' => $res->data[$i]->BankName,
                'branch_name' => $res->data[$i]->BankBranch,
                // 'address_1' => $res->data[$i]->EmployeeStatus,
                // 'address_2' => $res->data[$i]->EmployeeStatus,
                // 'address_3' => $res->data[$i]->EmployeeStatus,
                // 'address_district' => $res->data[$i]->EmployeeStatus,
                // 'address_state' => $res->data[$i]->EmployeeStatus,
                // 'address_pin_code' => $res->data[$i]->EmployeeStatus,
                'beneficiary_name' => $res->data[$i]->Name,
                // 'account_base_type'=>$res->data[$i]->EmployeeStatus,
                // 'transfer_type'=>$res->data[$i]->EmployeeStatus,
                // 'account_type'=>$res->data[$i]->EmployeeStatus,
                'iag_code' => $res->data[$i]->EmployeeStatus,
                'pfu' => $pfu

            ]);
        }

        // 'account_number' => $row['account_number'],
        // 'ifsc' => $row['ifsc_code'],
        // 'bank_name' => $row['bank_name'],


        if ($sender_table->ax_id != $res->data[$i]->Name) {
            // print_r($sender_table->last_working_date);
            $updated_details['updated_id'] = $sender_table->id;

          $updated_details['updated_field'] = 'AX CODE  Changed from ' . $sender_table->ax_id . ' to ' . $res->data[$i]->Name;

            $ax_code_update = Sender::where('id', $sender_table->id)->update(['ax_id' => $res->data[$i]->Name]);

        
            if ($ax_code_update) {
                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                // echo "<pre>";print_r($updated_record_detail);
            }
        }

        if ($sender_table->account_number != $res->data[$i]->AccountNo) {
            // print_r($sender_table->last_working_date);
            $updated_details['updated_id'] = $sender_table->id;
           $updated_details['updated_field'] = 'Account Number  Changed from ' . $sender_table->account_number . ' to ' . $res->data[$i]->AccountNo;

            $account_number_update = Sender::where('id', $sender_table->id)->update(['account_number' => $res->data[$i]->AccountNo]);


            if ($account_number_update) {
                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                // echo "<pre>";print_r($updated_record_detail);
            }
        }

        // print_r(($row['beneficiary_name']));
        // print_r($sender_table->beneficiary_name);
        // exit;

        if ($sender_table->beneficiary_name != $res->data[$i]->Name) {
            // print_r($sender_table->last_working_date);
            $updated_details['updated_id'] = $sender_table->id;
            $ifsc_code_update = Sender::where('id', $sender_table->id)->update(['beneficiary_name' => $res->data[$i]->Name]);

            $updated_details['updated_field'] = 'Beneficiary Name  Changed from ' . $sender_table->beneficiary_name . ' to ' . $res->data[$i]->Name;

            if ($ifsc_code_update) {
                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                // echo "<pre>";print_r($updated_record_detail);
            }
        }
        if ($sender_table->branch_name != $res->data[$i]->BankBranch) {
            // print_r($sender_table->last_working_date);
            $updated_details['updated_id'] = $sender_table->id;
                $updated_details['updated_field'] = 'Branch Name Changed from ' . $sender_table->branch_name . ' to ' . $res->data[$i]->BankBranch;

            $branch_name_update = Sender::where('id', $sender_table->id)->update(['branch_name' => $res->data[$i]->BankBranch]);


            if ($branch_name_update) {
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
        if (empty($row['date_of_leaving']) && !empty($sender_table->last_working_date)) {
            $updated_details['updated_id'] = $sender_table->id;
            $date_of_leaving_update = Sender::where('id', $sender_table->id)->update(['last_working_date' => "", 'status' => 'Active']);
            $updated_details['updated_field'] = 'Date of Leaving has been Removed as ' . $sender_table->last_working_date;
            if ($date_of_leaving_update) {
                $updated_record_detail = DB::table('spine_hr_dump_updates')->insert($updated_details);
                // echo "<pre>";
                // print_r($updated_record_detail);
            }
        } else {


            if (!empty($lastworkingdate) || $row['date_of_leaving'] != $sender_table->last_working_date) {

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
                    } else if (strtotime($sender_table->last_working_date) >= strtotime($lastworkingdate)) {
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
                    } else {

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
            } else {

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
    }
}
