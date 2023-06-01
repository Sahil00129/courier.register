@extends('layouts.main')
@section('title', 'Add Invoice')
@section('content')

<style>
    .list-group {
        width: 500px !important;

        padding: 10px !important;
        list-style-type: none;
    }

    .list-group {
        max-height: 439px;
        overflow-y: auto;
        overflow-x: scroll;
    }

    #product_list {
        position: absolute;
        background: #e2e2e2;
        z-index: 9999;
        margin-top: 10px;
    }

    * html .ui-autocomplete {
        height: 100px;
    }

    li:hover {
        color: #1f4eaf;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1px solid rgba(0, 0, 0, .125);
        color: #000;
    }

    .select2 {
        margin-bottom: 0 !important;
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
        width: 100%;
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

    .imageBlock {
        /* width: 150px; */
        /* height: 150px; */
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .imageBlock img {
        margin: 10px;
        width: 140px;
        height: 140px;
        border-radius: 8px;
        object-fit: contain;
        background: #83838330;
        padding: 6px;
    }

    #imageUploadSection {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
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

    .appendedSection {
        position: relative;
    }

    .closeIconX {
        position: absolute;
        top: 10px;
        right: 0;
        cursor: pointer;
        outline: 1px solid;
        height: 1.2rem;
        width: 1.2rem;
        display: grid;
        place-items: center;
        border-radius: 50%;
        font-size: 14px;
        line-height: 14px;
    }
</style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing editTer">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div id="loadingBlock" class="loadingBlock justify-content-center align-items-center" style="display: none;">Submitting...</div>
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Add Invoice</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <form class="general_form row mx-0" method="POST" enctype="multipart/form-data" action="{{url('/invoices')}}" id="createinvoice">

                            <div class="form-row mb-4">
                                <h6><b>PO Details</b></h6>
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
                                    <input type="text" class="form-control form-control-sm" name="po_value" id="po_value" placeholder="" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Sender Details</b></h6>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Vendor Code</label>
                                    <input type="text" class="form-control form-control-sm" name="vendor_code" id="vendor_code" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Vendor Name</label>
                                    <input type="text" class="form-control form-control-sm" name="vendor_name" id="vendor_name" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Unit</label>
                                    <input type="text" class="form-control form-control-sm" name="po_unit" id="po_unit" placeholder="" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Invoice Details</b></h6>

                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Invoice Number</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice_no" id="invoice_no" placeholder="">
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Invoice Date</label>
                                    <input type="date" class="form-control form-control-sm" name="invoice_date" id="invoice_date" placeholder="">
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Basic Amount(Before Tax)</label>
                                    <input type="number" class="form-control form-control-sm" name="basic_amount" id="basic_amount" placeholder="">
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Total Amount</label>
                                    <input type="number" class="form-control form-control-sm" name="total_amount" id="total_amount" placeholder="">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Courier Details</b></h6>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Courier Name *</label>
                                    <select id="slct" name="courier_id" id="courier_id" class="form-control form-control-sm" required>
                                        <option></option>
                                        @foreach($couriers as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Courier Received Date</label>
                                    <input type="date" class="form-control form-control-sm" name="received_date" id="received_date" placeholder="">
                                </div>


                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Docket No.*</label>
                                    <input type="text" class="form-control form-control-sm" name="docket_no" id="docket_no" placeholder="">
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Docket Date</label>
                                    <input type="date" class="form-control form-control-sm" name="docket_date" id="docket_date" placeholder="">
                                </div>



                            </div>

                            <!-- Image Required removed -->
                            <div id="imageUploadSection" class="row">
                                <div class="form-group col-md-12">
                                    <label class="col-form-label pb-0">Upload File</label>
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" multiple name="scanning_file[]" class="amit form-control-file  form-control-file-sm" id="fileupload-0"  />
                                    <div class="imageBlock"></div>
                                </div>
                            </div>

                            <button id="appendButtons" class="btn btn-outline-secondary" style="display: none;" onclick="appendImageSection()" type="button">Add More Image</button>


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

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    $("#basic_amount").blur(function() {
        let check_flag = true;
        if ($("#po_value").val() == "unknown") {
            check_flag = false;
        }

        // alert($("#po_value").val())
        if (check_flag) {
            if ($("#basic_amount").val() > parseInt($("#po_value").val())) {
                $("#basic_amount").val("");
                swal('error', "Basic Amount Can't be Greater than PO Value")
            }
        }else{
            if ($("#basic_amount").val() > parseInt($("#total_amount").val())) {
                $("#basic_amount").val("");
                swal('error', "Basic Amount Can't be Greater than Total Amount")
            }
        }

    });
    $("#total_amount").blur(function() {
        // alert($("#po_value").val());
        // alert($("#total_amount").val());
        let check_flag = true;
        if ($("#po_value").val() == "unknown") {
            check_flag = false;
        }
        if (check_flag) {
            if ($("#total_amount").val() > parseInt($("#po_value").val())) {
                $("#total_amount").val("");
                swal('error', "Total Amount Can't be Greater than PO Value")
            }
        }else{
            if ($("#basic_amount").val() > parseInt($("#total_amount").val())) {
                $("#basic_amount").val("");
                swal('error', "Basic Amount Can't be Greater than Total Amount")
            }
        }
       

    });




    const imageUploadSection = $('#imageUploadSection')
    let i = 1;

    const appendImageSection = () => {
        if (i < 5) {
            console.log('sss ', i);
            let sectionToAppend = ``;
            sectionToAppend += `<div class="form-group col-md-3 appendedSection">
                                    <label class="col-form-label pb-0">Upload File</label>
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" multiple name="scanning_file[${i}]" class="amit form-control-file  form-control-file-sm" id="fileupload-${i}" required/>
                                    <div class="imageBlock"></div>
                                    <span class="closeIconX">x</span>
                                </div>`;
            imageUploadSection.append(sectionToAppend);
            i++;
        } else {
            swal('error', 'Maximum upload limit is 5', 'error');
        }
    }

    $(document).on("click", '.closeIconX', function(e) {
        let currentSection = $(this).closest('.appendedSection');
        console.log(currentSection);
        currentSection.remove();
    });


    $(document).on("change", '.amit', function(e) {
        let image = ``;
        let imageBlock = $(this).next('.imageBlock')[0];
        let imgSrc = URL.createObjectURL($(this)[0].files[0]);

        for (let i = 0; i < $(this)[0].files.length; i++) {
            let imgSrcw = URL.createObjectURL($(this)[0].files[i]);
            image += `<img src="` + imgSrcw + `" alt="your image">`;
        }
        imageBlock.innerHTML = image;
        // $('#appendButtons').show();
    });
</script>

@endsection