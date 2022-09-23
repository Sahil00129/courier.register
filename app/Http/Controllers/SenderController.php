<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sender;
use DB;
use URL;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;

class SenderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:add-sender' ,['only' => ['addSenderIndex']]);
        $this->middleware('permission:sender-table-show', ['only' => ['senderTable']]);
    }


    public function addSenderIndex()
    {
        return view ('pages.add-sender');
    }

    public function senderTable(Request $request)
    {
        $sends = Sender::all();
        $user = Auth::user();
        $data = json_decode(json_encode($user));
        // echo'<pre>'; print_r($data); die;
        $name = $data->roles[0]->name;
        $flag=0;
        $flag_hr=0;
        // echo'<pre>'; print_r($name); die;
        if ($name === "tr admin" || $name === "Hr Admin") {
          $flag=1;
        }
        if ($name === "Hr Admin") {
            $flag_hr=1;
          }

        return view ('pages.sender-table',  ['sends' => $sends,'flag'=>$flag,'flag_hr'=>$flag_hr])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function addSender(Request $request) 
    {
        $sender = new Sender;
        $sender->name = $request->name; 
        $sender->type = $request->type;
        // if($request->type == 'Other')
        // {
        //    $sender->type = $request->other_type;
        // }else{
        // $sender->type = $request->type;
        // }
        $sender->location = $request->location;
        $sender->telephone_no = $request->telephone_no;

        $S = DB::table('sender_details')
                ->where('name', '=', $request['name'])
                ->where('telephone_no', '=', $request['telephone_no'])
                ->first();
        if(is_null($S)) {
            $sender->save();
            $response['success'] = true;
            $response['messages'] = 'Succesfully imported';
        }else{
            $response['success'] = false;
            $response['messages'] = 'Data already exist';
        }
        return Response::json($response);
    }

    public function editSender($id)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($id);
        $sender = Sender::where('id',$id)->first();
        return view('pages.update-sender')->with(['prefix'=>$this->prefix,'sender'=>$sender]);
    }

    public function updateSender(Request $request)
    {
        try { 
            $this->prefix = request()->route()->getPrefix();
             $rules = array(
              'name' => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                $errors                 = $validator->errors();
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
                return response()->json($response);
            }
            $sendersave['name']         = $request->name;
            $sendersave['telephone_no'] = $request->telephone_no;
            $sendersave['location']   = $request->location;
            $sendersave['type']       = $request->type;
            
            $savesender = Sender::where('id',$request->sender_id)->update($sendersave);

            if($savesender)
            {
                $url    =   URL::to($this->prefix.'sender-table');

                $response['redirect_url']    = $url;
                $response['success']         = true;
                $response['success_message'] = "Sender Updated Successfully";
                $response['error']           = false;
                $response['page']            = 'sender-update';
                $response['redirect_url']  = $url;
            }
        }catch(Exception $e) {
            $response['error']         = false;
            $response['error_message'] = $e;
            $response['success']       = false;
            $response['redirect_url']  = $url;   
        }
        return response()->json($response);
    }

    public function deleteSender(Request $request)
    {
        Sender::where('id',$request->senderid)->delete();
        $url    =   URL::to('sender-table');
        $response['success']         = true;
        $response['success_message'] = 'Sender deleted successfully';
        $response['error']           = false;
        $response['redirect_url']    = $url;
        return response()->json($response);
    }

}
