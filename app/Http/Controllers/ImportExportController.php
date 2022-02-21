<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BulkImport;
use Response;
class ImportExportController extends Controller
{
    
public function ImportExcel()
{
    return view('pages.import-data');
}

   public function Import() 
{
    if($_POST['import_type'] == 1){
    try
    {     
       //echo'<pre>'; print_r($_FILES); die;
        $data = Excel::import(new BulkImport, request()->file('file'));
        $response['success'] = true;
        $response['messages'] = 'Succesfully imported';
        return Response::json($response);
    
    }catch (\Exception $e) {
      $response['success'] = false;
      $response['messages'] = 'something wrong';
      echo'<pre>'; print_r($e); die;
      return Response::json($e);
    }

  }elseif($_POST['import_type'] == 2){
   //echo '<pre>'; print_r($_FILES); die;
    try
     {      
   // echo'<pre>'; print_r($_FILES); die;
     $data = Excel::import(new BulkImport, request()->file('file'));
     $response['success'] = true;
     $response['messages'] = 'Succesfully imported';
     return Response::json($response);
   
     }catch (\Exception $e) {
     $response['success'] = false;
     $response['messages'] = 'something wrong';
     return Response::json($response);
    }

    }elseif($_POST['import_type'] == 3){

   try
  {      
  //echo'<pre>'; print_r($_POST); die;
  $data = Excel::import(new BulkImport, request()->file('file'));
  $response['success'] = true;
  $response['messages'] = 'Succesfully imported';
  return Response::json($response);

  }catch (\Exception $e) {
  $response['success'] = false;
  $response['messages'] = 'something wrong';
  return Response::json($response);
}

}elseif($_POST['import_type'] == 4){

try
{      
//echo'<pre>'; print_r($_POST); die;
  $data = Excel::import(new BulkImport, request()->file('file'));
  $response['success'] = true;
  $response['messages'] = 'Succesfully imported';
  return Response::json($response);

  }catch (\Exception $e) {
  $response['success'] = false;
  $response['messages'] = 'something wrong';
  return Response::json($response);
}

} 
//return back();
}

}
