@extends('layouts.main')
@section('title', 'Create PO')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pos</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create PO</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form row" method="POST" action="{{url('/pos')}}" id="createpo">
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Ax Code</label>
                                <input type="text" class="form-control" name="ax_code" id="ax_code" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Number</label>
                                <input type="text" class="form-control" name="po_number" id="name" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Vendor Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Value</label>
                                <input type="text" class="form-control" name="po_value" id="po_value" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Unit</label>
                                <select class="form-control" name="unit">
                                    <option value="">Select Unit</option>
                                    <option value="1">SD1</option>
                                    <option value="2">SD3</option>
                                    <option value="3">MA2</option>
                                    <option value="4">MA4</option>
                                </select>
                                <!-- <input type="text" class="form-control" name="unit" id="unit" placeholder=""> -->
                            </div>
                            
                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                            <a class="btn btn-outline-primary" href="{{url('/pos') }}"> Back</a>
                                <button type="submit" class="mt-4 mb-4 btn btn-primary">Submit</button>
                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection