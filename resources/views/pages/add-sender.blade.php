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
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Add Sender</a></li>
                </ol>
            </nav>       
        </div>
        <div class="row">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Add Sender</h4>
                            </div>   
                        </div>
                    </div>
                    <form id="new_sender_add" method="post">
                        @csrf
                        <div class="widget-content widget-content-area">
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4" class="required">Sender Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Type</label>
                                    <select id="type" name="type" class="form-control" onchange="typeCheck(this);">
                                        <option selected disabled>Select..</option>
                                        <option value="Cutomer">Customer</option>
                                        <option value="Government Department">Government Department</option>
                                        <option value="Vendors">Vendors</option>
                                        <option value="Warehouse">Warehouse</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Corteva">Corteva</option>
                                        <option value="FMC">FMC</option>
                                        <option value="Buyer">Buyer</option>
                                        <option value="Godrej">Godrej</option>
                                        <option value="Investements">Investements</option>
                                        <option value="Employee">Employee</option>
                                        <option value="Other">Other</option>               
                                    </select>
                                    <br>
                        <!---- courier other field ---->
                                    <!-- <div id="ifYes_type" style="display: none;">
                                        <input type="text" class="form-control" id="" name="other_type"  placeholder="other type" autocomplete="off">
                                    </div> -->
                        <!---- end ---->
                                </div>
                            </div>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Location</label>
                                    <input type="text" class="form-control" id="location" placeholder="" name="location" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control mbCheckNm" name="telephone_no" id="telephone_no" maxlength="10" placeholder="" autocomplete="off">
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