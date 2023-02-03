<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use App\Models\Location;
use App\Models\Department;
date_default_timezone_set('Asia/Kolkata');

class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'asc')->paginate(15);
        
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $getcompanys = Company::all();

        return view('users.create', compact('roles','getcompanys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['role'] = $input['roles'][0];
        $input['text_password']=$input['password_confirmation'];
        $input['company_id'] = $input['company_id'];
        $input['location_id'] = $input['location_id'];
        $input['department_id'] = $input['department_id'];

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $companies = Company::select('id', 'name')->get();
        $locations = Location::select('id', 'name','company_id')->get();
        $departments = Department::select('id', 'name','location_id')->get();
    
        return view('users.edit', compact('user', 'roles', 'userRole','companies','locations','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'confirmed',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        $getpass = User::where('id',$id)->get();
        // echo "<pre>"; print_r($input); die;
        // if(!empty($input['password'])) { 
        //     $input['password'] = Hash::make($input['password']);
        // } else {
        //     $input = Arr::except($input, array('password'));    
        // }

        if(!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
            $input['text_password'] = $input['password_confirmation'];
            
        }else {
            $input['password'] = $getpass->password;  
            $input['text_password'] = $getpass->text_password; 
        }

        $input['company_id'] = $input['company_id'];
        $input['location_id'] = $input['location_id'];
        $input['department_id'] = $input['department_id'];

        // User::where('id', $id)->update($input);    
        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function getLocation(Request $request){
        $getlocations = Location::select('id', 'name')->where('company_id', $request->company_id)->get();

        if ($getlocations) {
            $response['success'] = true;
            $response['success_message'] = "Location list fetch successfully";
            $response['error'] = false;
            $response['data'] = $getlocations;

        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch location list please try again";
            $response['error'] = true;
        }
        return response()->json($response);

    }

    // get consigner address on change
    public function getDepartment(Request $request)
    {
        $getdepartments = Department::select('id','location_id','name')->where(['location_id' => $request->location_id, 'status' => '1'])->get();

        if ($getdepartments) {
            $response['success'] = true;
            $response['success_message'] = "Department list fetch successfully";
            $response['error'] = false;
            $response['data'] = $getdepartments;
        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch department list please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

}
