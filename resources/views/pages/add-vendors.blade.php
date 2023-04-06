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

    .loadingBlock {
        position: fixed;
        left: 50%;
        top: 0;
        background: #00000070;
        width: 100vw;
        height: 100%;
        transform: translateX(-50%);
        color: #fff;
        z-index: 999999;
        font-size: 1.1rem;
    }
</style>

<section class="container" style="position: relative">
    <div id="loadingBlock" class="loadingBlock justify-content-center align-items-center" style="display: none;">Submitting...</div>
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

                <!-- <form class="forms-sample" id="vForms" method="post" enctype="multipart/form-data" method="POST" > -->

                <div class="form-row mb-4 pt-4">
                    <h6><b>PO mandatory Fields</b></h6>
                    <div class="form-group col-md-3">
                        <label for="">Select PFU</label>
                        <select name="pfu" id="pfu" class="form-control" required style="width:99%;">
                            <option value="">--Select--</option>
                            <option value="SD1">SD1</option>
                            <option value="MA2">MA2</option>
                            <option value="SD3">SD3</option>
                            <option value="MA4">MA4</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12 n-chk align-self-center">
                        <label class="new-control new-radio radio-classic-primary">
                            <input onchange="onChnageGstStatus()" id="registered" type="radio" checked="checked" class="new-control-input" name="gstStatus">
                            <span class="new-control-indicator"></span>Registered
                        </label>
                        <label class="new-control new-radio radio-classic-primary">
                            <input onchange="onChnageGstStatus()" id="unRegistered" type="radio" class="new-control-input" name="gstStatus">
                            <span class="new-control-indicator"></span>Un-registered
                        </label>
                    </div>

                    <div class="form-group col-md-3" id="gstNo">
                        <label for="">GSTIN</label>
                        <input type="text" class="form-control"  id="gst" name="gst" placeholder="GSTIN" required>
                    </div>
                    <!-- <div class="form-group col-md-3" id="panNo" style="display: none;"> -->
                    <div class="form-group col-md-3" id="panNo">
                        <label for="">PAN</label>
                        <input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="PAN">
                    </div>



                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Company Name</label>
                        <input type="text" class="form-control form-control-sm" name="vname" required id="vname" placeholder="Company Name">
                    </div>


                    <div class="form-group col-md-3">
                        <label for="">Contact Name</label>
                        <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Contact Name" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="">Contact Phone</label>
                        <small id="cp" class="" style="position: absolute;right: 0;background: white;top: 20px;font-size: 11px;margin-right: 8%;"></small>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="">Pincode</label>
                        <input type="text" class="form-control"  name="pincode" id="pincode" placeholder="Pincode">
                    </div>

                    <!-- <div class="form-group col-md-3">
                        <label for="">State</label>
                        <input type="text" class="form-control" name="state" id="state" disabled>
                    </div> -->
                    <!-- <div class="form-group col-md-3">
                        <label for="">District</label>
                        <input type="text" class="form-control" name="district" id="district" placeholder="Pincode">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Pincode">
                    </div> -->


                    <div class="form-group col-md-3">
                        <label for="">State</label>
                        <select name="state" id="state" class="form-control" required style="width:99%;">
                            <option value="">--Select--</option>
                            @foreach($state_json_data as $state_names)
                            <option value="{{$state_names['state']}}">{{$state_names['state']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Address</label>
                        <textarea class="form-control" name="vaddress" id="vaddress" rows="1"></textarea>
                    </div>


                </div>

                <div class="form-row mb-4 pt-4">
                    <h6><b>Invoice booking Mandatory Fields</b></h6>
                    <div class="form-group col-md-3">
                        <label for="">Account Holder Name</label>
                        <input type="text" class="form-control" name="ahn" id="ahn" placeholder="Acc Holder Name">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Account No</label>
                        <input type="number" class="form-control" name="ano" id="ano" placeholder="Acc No">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="IFSC Code">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Bank Name</label>
                        <select name="bname" id="bname" class="form-control" style="width:99%;">
                            <option value="">--Select--</option>
                            @foreach($bank_json_data as $bank_names)
                            <option value="{{$bank_names['BankName']}}">{{$bank_names['BankName']}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="">Bank Address</label>
                        <textarea class="form-control" name="baddress" id="baddress" rows="1"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label><strong> Cheque File Upload</strong></label>
                        <input type="file" name="url" id="url" class="form-control file-upload-default">
                    </div>
                </div>




                <div class="form-row mb-4 pt-4">
                    <h6><b>Other Details Info</b></h6>
                    <div class="form-group col-md-4">
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
                    <div class="form-group col-md-4">
                        <label for="">Nature of Service or Goods</label>
                        <input type="text" name="nosorg" class="form-control" id="nosorg" placeholder="Nature of Service or Goods">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">MSME Number</label>
                        <input type="text" name="msme_reg_no" class="form-control" id="msme_reg_no" placeholder="MSME Number">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Contact Email</label>
                        <small id="ce" class="" style="position: absolute;right: 0;background: white;top: 20px;font-size: 11px;margin-right: 8%;"></small>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Contact Designation</label>
                        <input type="text" class="form-control" name="cdesignation" id="cdesignation" placeholder="Designation">
                    </div>


                    <div class="form-group col-md-4">
                        <label for="">Owner Name</label>
                        <input type="text" name="owner_name" class="form-control" id="owner_name" placeholder="Owner Name">
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
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>

<script>
    const registered = document.getElementById('registered')
    const unRegistered = document.getElementById('unRegistered')

    function onChnageGstStatus() {
        if (registered.checked) {
            // document.getElementById('panNo').style.display = "none";
            document.getElementById('gst').setAttribute("required", "true");
            document.getElementById('pan_no').removeAttribute("required")
            // document.getElementById('gstNo').style.display = "block";
        } else if (unRegistered.checked) {
            // document.getElementById('gstNo').style.display = "none";
            document.getElementById('pan_no').setAttribute("required", "true");
            document.getElementById('gst').removeAttribute("required")
            // document.getElementById('panNo').style.display = "block";
        }

    }
    // $("#pincode").blur(function() {
    //    var pincode;
    //       pincode =  $("#pincode").val();
    //       $.ajax({
    //     url: "https://api.postalpincode.in/pincode/"+pincode,
    //     // url: "https://beta.finfect.biz/api/getVendorList/"+unit,
    //     type: "get",
    //     // cache: false,
    //     // data: { po_id: po_id },
    //     // dataType: "json",
    //     beforeSend: function () {
    //         $("#state").empty();
          
    //     },
    //     success: function (res) {
    //         if(res){
               
    //              console.log(res.data[0].PostOffice[0].State);return 1;
            

    //             $("#state").val(res.data[0].PostOffice[0].state);
    //             // $("#po_unit").val(unit);
    //             // $("#vendor_code").val(res.data.vendor_code);
    //             // $("#vendor_name").val(res.data.vendor_name);

    //         }
    //     },
    // });
       

    // });
</script>

<!--<script>
            $('body').on('click', '.v-save-btn', function() {
                // alert("dd");
                // return 1;
            var name, email, phone, pic, gsturl, mmseurl;
            name = $("#vname").val();
            email = $("#email").val();
            phone = $('#phone').val();
            pic = $('#url').val();
            gsturl = $('#gst_url').val();
            mmseurl = $('#mmse_url').val();
      
                var formData = new FormData($('#vForms')[0]);

                formData.append('url', $('input[type=file]')[0].files[0]);
                formData.append('gst_url', $('input[type=file]')[0].files[0]);
                formData.append('others_url', $('input[type=file]')[0].files[0]);
                formData.append('mmse_url', $('input[type=file]')[0].files[0]);
                //alert(formdata);
                $.ajax({
                    url: 'https://beta.finfect.biz/api/add_vendor',
                    method: 'post',
                    data: formData,
                    //use contentType, processData for sure.
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.v-save-btn').text('PLEASE WAIT...');
                        $('.v-save-btn').attr('disabled', true);
                    },
                    success: function(result, status, xhr) {
                        $(".v-save-btn").text('SUBMIT');
                        var da = jQuery.parseJSON(result);
                        //console.log(da);
                        if (da.status == 0) {
                            $.notify({
                                // options
                                message: da.message
                            }, {
                                // settings
                                type: 'danger'
                            });
                            $('.v-save-btn').attr('disabled', false);
                        } else if (da.status == 1) {
                            $.notify({
                                // options
                                message: da.message
                            }, {
                                // settings
                                type: 'success'
                            });
                            $(".v-reset-btn").trigger('click');
                            $('.v-save-btn').attr('disabled', false);
                            location.reload();
                        }
                    }
                });
            
        });
</script> -->
@endsection