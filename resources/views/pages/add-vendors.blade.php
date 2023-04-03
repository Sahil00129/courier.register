@extends('layouts.main')
@section('title', 'Add Vendors')
@section('content')
<style>
    .required:after {
        content: " * ";
        color: red;
    }

    .form-control-sm-30 {
        height: calc(2.8em + 2px) !important;
    }

    .form-group label,
    label {
        font-size: 12px;
        margin-bottom: 0;
    }

    .editTer .form-row {
        border-radius: 12px;
        padding: 1rem 8px 2px;
        position: relative;
    }

    .editTer .form-row h6 {
        font-size: 0.875rem;
        position: absolute;
        top: -0.5rem;
        left: 1rem;
        background: #dee2f4;
        padding: 1px 8px;
        border-radius: 7px;
        box-shadow: 0 2px 2px #83838350;
    }


    input[type="file"]::file-selector-button {
        background: #ecfff5;
        padding: 1px 10px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        color: #28a745;
        border: 2px solid #28a745;
        transition: 1s;
    }

    input[type="file"]::file-selector-button:hover {
        border: 2px solid #28a745;
    }

    input[type="file"] {
        border: none;
        padding: 3px 0;
    }
</style>

<section class="container ">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Vendor Registeration Form</a></li>
            </ol>
        </nav>
    </div>
    <div class="row editTer">
        <div class="card-body">
            <form class="forms-sample" id="vForm" method="post" enctype="multipart/form-data" method="POST" action="{{url('/add_vendor_details')}}">
              

                <div class="form-row mb-4">
                    <h6><b>Vendor Info</b></h6>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="vname" id="vname" placeholder="Company Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Nature of ASSESSEe</label>
                        <select class="form-control form-control-sm" name="nature_of_assessee" id="nature_of_assessee">
                            <option value="">--Select--</option>
                            <option value="Proprietorship">Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <option value="HUF">HUF</option>
                            <option value="LLP">LLP</option>
                            <option value="Pvt Ltd">Pvt Ltd</option>
                            <option value="Public Ltd">Public Ltd</option>
                            <option value="Coop Society">Coop Society</option>
                            <option value="AOP">AOP</option>
                            <option value="BOI">BOI</option>
                            <option value="Company">Company</option>
                            <option value="Firm">Firm</option>
                            <option value="Individual">Individual</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="">Contact Name</label>
                        <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Contact Name" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Contact Email</label>
                        <small id="ce" class="" style="position: absolute;right: 0;background: white;top: 20px;font-size: 11px;margin-right: 8%;"></small>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Contact Phone</label>
                        <small id="cp" class="" style="position: absolute;right: 0;background: white;top: 20px;font-size: 11px;margin-right: 8%;"></small>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Contact Designation</label>
                        <input type="text" class="form-control" name="cdesignation" id="cdesignation" placeholder="Designation">
                    </div>


                    <div class="form-group col-md-3">
                        <label for="">State</label>
                        <select name="state" id="state" class="form-control" required style="width:99%;">
                            <option value="">--Select--</option>
                            @foreach($state_json_data as $state_names)
                            <option value="{{$state_names['state']}}">{{$state_names['state']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Pincode</label>
                        <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Address</label>
                        <textarea class="form-control" name="vaddress" id="vaddress" rows="1"></textarea>
                    </div>
                </div>



                <div class="form-row mb-4">
                    <h6><b>Bank Info</b></h6>
                    <div class="form-group col-md-3">
                        <label for="">Bank Name</label>
                        <select name="bname" id="bname" class="form-control"  style="width:99%;">
                            <option value="">--Select--</option>
                            @foreach($bank_json_data as $bank_names)
                            <option value="{{$bank_names['BankName']}}">{{$bank_names['BankName']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Account No</label>
                        <input type="text" class="form-control" name="ano" id="ano" placeholder="Acc No">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Account Holder Name</label>
                        <input type="text" class="form-control" name="ahn" id="ahn" placeholder="Acc Holder Name">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="IFSC Code">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Address</label>
                        <textarea class="form-control" name="baddress" id="baddress" rows="1"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong> Cheque File Upload</strong></label>
                        <input type="file" name="url" id="url" class="form-control file-upload-default">
                    </div>
                </div>


                <div class="form-row mb-4">
                    <h6><b>PFU Info</b></h6>
                    <div class="form-group col-md-3">
                        <select name="pfu" id="pfu" class="form-control" required style="width:99%;">
                            <option value="">--Select--</option>
                            <option value="SD1">SD1</option>
                            <option value="MA2">MA2</option>
                            <option value="SD3">SD3</option>
                            <option value="MA4">MA4</option>
                        </select>
                    </div>
                </div>

                <div class="form-row mb-4">
                    <h6><b>Other Details Info</b></h6>
                    <div class="form-group col-md-3">
                        <label for="">MSME Number</label>
                        <input type="text" name="msme_reg_no" class="form-control" id="msme_reg_no" placeholder="MSME Number">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">GST Number</label>
                        <small id="cgst" class="" style="position: absolute;right: 0;background: white;top: 20px;font-size: 11px;margin-right: 8%;"></small>
                        <input type="text" name="gst" class="form-control" id="gst" placeholder="GST">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Owner Name</label>
                        <input type="text" name="owner_name" class="form-control" id="owner_name" placeholder="Owner Name">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Nature of Service or Goods</label>
                        <input type="text" name="nosorg" class="form-control" id="nosorg" placeholder="Nature of Service or Goods">
                    </div>

                    <div class="form-group col-md-4">
                        <label><strong> Certificate Upload</strong></label>
                        <input type="file" name="gst_url" id="gst_url" class="form-control file-upload-default">
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong>MSME Registration Number Upload</strong></label>
                        <input type="file" name="mmse_url" id="mmse_url" class="form-control file-upload-default">
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong> File Upload</strong></label>
                        <input type="file" name="others_url" id="others_url" class="form-control file-upload-default">
                    </div>
                </div>

            


                <div class="d-flex align-items-center justify-content-end" style="gap: 1rem">
                    <button class="btn btn-light v-reset-btn" type="reset">Cancel</button>
                    <button type="submit" class="btn btn-primary mr-2 v-save-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection