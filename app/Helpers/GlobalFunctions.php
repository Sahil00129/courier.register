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
    public static function rupee_format($num) {
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){
                // creates each of the 2's group and adds a comma to the end
                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }

}