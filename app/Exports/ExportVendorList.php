<?php

namespace App\Exports;

use App\Models\VendorDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVendorList implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://uat.finfect.biz/api/getAllVendors',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);
        $data= $res->data;
  
        // return $res->data;
        // $vendors = $res->data;
        // echo "<pre>";
        // print_r($res->data);
        // exit;

        $size=sizeof($data);
        // $val="";

        // [vname] => Tax Authority-Value Added Tax
        // [vcode] => A0001
        // [email] => 
        // [phone] => 9876023480
        // [pfu] => 2


        $arr_instrulist_excel[] =array();
        for($i=0;$i<$size;$i++)
        {
            $unit=$data[$i]->pfu;
            if ($unit == "1") {
                $pfu = "SD1";
            } elseif ($unit == "3") {
                $pfu = "SD3";
            } elseif ($unit == "2") {
                $pfu = "MA2";
            } elseif ($unit == "4") {
                $pfu = "MA4";
            }
      
                $arr_instrulist_excel[] = array(
                    's.no.' => $i + 1,
                    'vendor_name' => $data[$i]->vname,
                    'vendor_code'  => $data[$i]->vcode,
                    'email'=>$data[$i]->email,
                    'unit' =>  $pfu,
                );

            }
   
            return collect($arr_instrulist_excel);

    }
    

    public function headings(): array
    {
        return [
            "S.No.","Vendor Name", "Vendor Code","Email",
           "Unit"
        ];
    }
}
