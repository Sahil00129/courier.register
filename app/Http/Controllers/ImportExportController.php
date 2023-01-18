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
                $response['messages'] = 'Succesfully imported';
                $response['import_type'] = $type;
                return Response::json($response);
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 6) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 7) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 8) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 9) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 10) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 11) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
        elseif ($_POST['import_type'] == 12) {
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
                $response['messages'] = 'something wrong'. $e;
                return Response::json($response);
            }
        }
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
      if($type == "ter_timeline")
      {
        return Excel::download(new ExportTerTimeline,'tertimeline_report.xlsx');
      }
      else if($type == "ter_cancel")
      {
        return Excel::download(new ExportTerCancel,'ter_cancel_report.xlsx');
        // return Excel::download(new ExportTerReport, 'tercourier_report.xlsx');
      }
      else if($type=="ter_updates")
      {
        return Excel::download(new ExportTerUpdates,'ter_updates_report.xlsx');
      }
      else if($type=="ter_user_wise")
      {
        return Excel::download(new ExportTerUserWise,'ter_user_wise_report.xlsx');
      }
      else if($type=="emp_ledger")
      {
        return Excel::download(new ExportTerEmpLedger,'ter_emp_ledger_report.xlsx');
      }
      else if($type=="emp_list")
      {
        return Excel::download(new ExportEmployee, 'employee_report.xlsx');
      }
     
      
    }
}
