<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildTercouriers;
use App\Models\Tercourier;
use App\Models\Sender;
use DB;
use Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use AshAllenDesign\ShortURL\Facades\ShortURL;


date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', -1);

class SamplePage extends Controller
{
    public function sample_page()
    {
        return view('sample-page/sample-page');
    }
}
