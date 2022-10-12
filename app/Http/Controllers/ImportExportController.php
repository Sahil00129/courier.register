<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BulkImport;
use App\Exports\ExportEmployee;
use App\Exports\ExportTerReport;
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
    }

    public function ExportSender()
    {
        return Excel::download(new ExportEmployee, 'employee_report.xlsx');

    }

    public function ExportSavedEntry()
    {
        return Excel::download(new ExportTerReport, 'tercourier_report.xlsx');
    }
}
