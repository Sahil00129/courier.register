<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sender;
use DB;
use Response;

class SenderController extends Controller
{
   public function addSenderIndex()
   {
       return view ('pages.add-sender');
   }

   public function senderTable()
   {
         $sends = Sender::all();
         return view ('pages.sender-table',  ['sends' => $sends]);
   }

   public function addSender(Request $request) 
   {
     //echo"<pre>"; print_r($_POST); die;
       $sender = new Sender;
       $sender->name = $request->name; 
       $sender->type = $request->type;
       $sender->location = $request->location;
       $sender->telephone_no = $request->telephone_no;


        $S = DB::table('sender_details')
       ->where('name', '=', $request['name'])
       ->where('telephone_no', '=', $request['telephone_no'])
       ->first();
       //echo"<pre>"; print_r($S); die;
       if(is_null($S)) {
       $sender->save();
     
       $response['success'] = true;
       $response['messages'] = 'Succesfully imported';
       return Response::json($response);
       }else{
           $response['success'] = false;
           $response['messages'] = 'Data already exist';
           return Response::json($response);
       }
       
   }
}
