<?php
namespace App\Helpers;
use DOMDocument;
use DB;
use Mail;
use Session;
use Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Location;
use App\Models\State;
use App\Models\Consigner;
use App\Models\ConsignmentNote;
use URL;
use Crypt;
use Storage;
use Image;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class GlobalFunctions {

    // function for show date in frontend //
    public static function ShowFormatDate($date){
        if(!empty($date)){
        $changeformat = date('d-M-Y',strtotime($date));
        }else{
        $changeformat = '-';
        }
        return $changeformat;
    }

    // function for show date and time in frontend ///

    public static function ShowFormat($date){
        $changeformat = date('d-m-Y',strtotime($date));
        return $changeformat;
    }

}