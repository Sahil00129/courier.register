@extends('layouts.main')
@section('title', 'Create PO')
@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Create Invoice</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form row" method="POST" action="{{url('/invoices')}}" id="createinvoice">
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Number</label>
                                <select class="form-control form-control-sm basic" name="po_id" id="select_po" required>
                                    <option selected disabled>search..</option>
                                    @foreach($pos as $po)
                                    <option value="{{$po->id}}">{{$po->po_number}}  
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">PO Value</label>
                                <input type="text" class="form-control" name="po_value" id="po_value" placeholder="" readonly>
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Vendor Code</label>
                                <input type="text" class="form-control" name="vendor_code" id="vendor_code" placeholder="" readonly >
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Vendor Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="" readonly >
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Unit</label>
                                <input type="text" class="form-control" name="po_unit" id="po_unit" placeholder="" readonly >
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Invoice Number</label>
                                <input type="text" class="form-control" name="invoice_no" id="invoice_no" placeholder="">
                            </div>
                        
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Basic Amount</label>
                                <input type="text" class="form-control" name="basic_amount" id="basic_amount" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Total Amount</label>
                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="">
                            </div>
                         
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Courier Received Date</label>
                                <input type="date" class="form-control" name="received_date" id="received_date" placeholder="">
                            </div>
                            <div class="form-group mb-4 col-md-6">
                                <label for="exampleFormControlInput2">Invoice Date</label>
                                <input type="date" class="form-control" name="invoice_date" id="invoice_date" placeholder="">
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