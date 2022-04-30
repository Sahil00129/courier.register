@extends('layouts.main')
@section('title', 'Add Sender')
@section('content')
<style>
    .required:after {
        content:" * ";
        color: red;
    }  
</style>
<div class="container">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Update Sender</a></li>
                </ol>
            </nav>       
        </div>
        <div class="row">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Update Sender</h4>
                            </div>   
                        </div>
                    </div>
                    <form id="update_sender" method="post" action="{{url($prefix.'update-sender')}}">
                        @csrf
                        <input type="hidden" name="sender_id" value="{{$sender->id}}">
                        <div class="widget-content widget-content-area">
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4" class="required">Sender Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$sender->name}}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Type</label>
                                    <select id="type" name="type" class="form-control" onchange="typeCheck(this);">
                                        <option selected disabled>Select..</option>
                                        <option value="Cutomer" {{$sender->type == 'Cutomer' ? 'selected' : ''}}>Customer</option>
                                        <option value="Government Department" {{$sender->type == 'Government Department' ? 'selected' : ''}}>Government Department</option>
                                        <option value="Vendors" {{$sender->type == 'Vendors' ? 'selected' : ''}}>Vendors</option>
                                        <option value="Internal" {{$sender->type == 'Internal' ? 'selected' : ''}}>Internal</option>
                                        <option value="Employee" {{$sender->type == 'Employee' ? 'selected' : ''}}>Employee</option>
                                        <option value="Other" {{$sender->type == 'Other' ? 'selected' : ''}}>Other</option>
                                    </select>
                                    <br>
                        <!---- courier other field ---->
                                    <div id="ifYes_type" style="display: none;">
                                        <input type="text" class="form-control" id="" name="other_type" value="{{$sender->other_type}}" placeholder="other type" autocomplete="off">
                                    </div>
                        <!---- end ---->
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="" name="location" value="{{$sender->location}}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control" name="telephone_no" id="telephone_no" value="{{$sender->telephone_no}}" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><span class="indicator-label">Save</span>
                            <span class="indicator-progress" style="display: none;">Please wait...
                    	    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span></button> 
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection