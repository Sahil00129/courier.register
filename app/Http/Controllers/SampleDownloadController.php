<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleDownloadController extends Controller
{
    public function senderSample()
    {
      
        $path = public_path('sample/sender_import.xlsx');
        return response()->download($path);
        
    }

    public function courierCompaniesSample()
    {
      
        $path = public_path('sample/courier_company.xlsx');
        return response()->download($path);
        
    }

    public function catagoreisSample()
    {
      
        $path = public_path('sample/Catagories.xlsx');
        return response()->download($path);
        
    }
    public function forSample()
    {
      
        $path = public_path('sample/for_Company.xlsx');
        return response()->download($path);
        
    }
}
