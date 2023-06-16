@extends('layouts.main')
@section('title', 'Add Remarks')
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
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        display: none;
    }
</style>

<div class="layout-px-spacing" id="divbox">
    <div class="row layout-top-spacing editTer">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Add Remarks</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <!-- <div class="breadcrumb-title pe-3"><h5>Create User</h5></div> -->
                </div>
                <div class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="general_form row mx-0">

                            <div class="form-row mb-4">
                                <h6><b>PO Details</b></h6>
                                <div class="form-group mb-4 col-md-6">
                                    <label for="exampleFormControlInput2">PO Number</label>
                                    <input type="text" class="form-control form-control-sm" name="po_number" id="po_number" value="<?php echo $po_data->po_number.' : '.$po_data->vendor_name.' : '.$po_data->unit ?>" placeholder="" readonly>
                                      
                                        <select class="form-control form-control-sm basic" name="po_id" id="select_po" required>
                                        <option selected disabled value="0">search..</option>
                                        @foreach($pos as $po)
                                        <option value="{{$po->id}}">{{$po->po_number}} : {{$po->vendor_name}} : {{$po->unit}} 
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" class="form-control form-control-sm" name="unid" id="unid" value="<?php echo $invoices_data->id ?>">

                                <div class="form-group mb-4 col-md-6">
                                    <label for="exampleFormControlInput2">PO Value</label>
                                    <input type="text" class="form-control form-control-sm" name="po_value" id="po_value" value="<?php echo $invoices_data->po_value ?>" placeholder="" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Sender Details</b></h6>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Vendor Code</label>
                                    <input type="text" class="form-control form-control-sm" name="vendor_code" id="vendor_code" value="<?php echo $invoices_data->employee_id ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Vendor Name</label>
                                    <input type="text" class="form-control form-control-sm" name="vendor_name" id="vendor_name" value="<?php echo $invoices_data->sender_name ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-4">
                                    <label for="exampleFormControlInput2">Unit</label>
                                    <input type="text" class="form-control form-control-sm" name="po_unit" id="po_unit" value="<?php echo $invoices_data->pfu ?>" placeholder="" readonly>
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Invoice Details</b></h6>

                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Invoice Number</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice_no" id="invoice_no" value="<?php echo $invoices_data->invoice_no ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Invoice Date</label>
                                    <input type="date" class="form-control form-control-sm" name="invoice_date" id="invoice_date" value="<?php echo $invoices_data->invoice_date ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Basic Amount(Before Tax)</label>
                                    <input type="number" class="form-control form-control-sm" name="basic_amount" id="basic_amount"  v-model="basic_amount" placeholder="">
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Total Amount</label>
                                    <input type="number" class="form-control form-control-sm" name="total_amount" id="total_amount" v-model="total_amount" placeholder="">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Courier Details</b></h6>

                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Courier Name</label>
                                    <input type="text" class="form-control form-control-sm" name="received_date" id="received_date" value="<?php echo $courier_name ?>" placeholder="" readonly>
                                </div>

                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Courier Received Date</label>
                                    <input type="date" class="form-control form-control-sm" name="received_date" id="received_date" value="<?php echo $invoices_data->received_date ?>" placeholder="" readonly>
                                </div>


                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Docket No.*</label>
                                    <input type="text" class="form-control form-control-sm" name="docket_no" id="docket_no" value="<?php echo $invoices_data->docket_no ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Docket Date</label>
                                    <input type="date" class="form-control form-control-sm" name="docket_date" id="docket_date" value="<?php echo $invoices_data->docket_date ?>" placeholder="" readonly>
                                </div>



                            </div>

                            @if(empty($invoices_data->hr_admin_remark))
                            <div class="form-row mb-4">
                                <h6><b>Sourcing Admin Remarks*</b></h6>

                                <div class="form-group mb-4 col-md-6" style="margin-top: 10px">
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" v-model="sourcing_admin_remarks" placeholder="">
                                </div>

                            </div>
                            @else
                            <div class="form-row mb-4">
                                <h6><b>Sourcing Admin Remarks*</b></h6>

                                <div class="form-group mb-4 col-md-6" style="margin-top: 10px">
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" value="<?php echo $invoices_data->hr_admin_remark ?>" readonly>
                                </div>

                            </div>
                            @endif

                            <!-- <div id="imageUploadSection" class="row">
                                <div class="form-group col-md-12">
                                    <label class="col-form-label pb-0">Upload File</label>
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" multiple name="scanning_file[]" v-on:change="upload_file($event)" class="amit form-control-file  form-control-file-sm" id="fileupload-0" required />
                                    <div class="imageBlock"></div>
                                </div>
                            </div>
                            <button id="appendButtons" class="btn btn-outline-secondary" style="display: none;" onclick="appendImageSection()" type="button">Add More Image</button> -->



                       
                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                                <button class="mt-4 mb-4 btn btn-primary" @click="update_data_invoice()">Update Invoice</button>
                            </div>
                        

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>

<script>
    
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
        $('#appendButtons').show();
    });
</script>`


<script>
    new Vue({
        el: '#divbox',
        // components: {
        //   ValidationProvider
        // },
        data: {

            unique_id: "",
            loader: false,
            sourcing_admin_remarks: "",
            file: "",
            basic_amount:"",
            total_amount:"",
            actual_po_info:"",
            po_value:"",
            date_of_receipt:"",
            invoice_number:"",
            invoice_date:"",
            po_id:"",
            old_basic_amount:"",
            old_total_amount:"",


        },
        mounted: function() {
            this.button_text = "Search";
            this.unique_id = document.getElementById('unid').value;
            // alert(this.unique_id)
            if (this.unique_id != "0") {
                this.get_data_by_id(this.unique_id);
            } 
           

        },
        created: function() {
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
        },
        methods: {
            update_data_invoice: function() {
             
               var po_selected_id= document.getElementById('select_po').value;
              
               if(po_selected_id != 0)
               {
                this.po_id=po_selected_id;
               }
           

                if(this.sourcing_admin_remarks == "")
                {
                    swal('error','Remarks are Mandatory','error')
                    return 1;
                }
             

                let check_flag = true;
                let check_total=true;
                if (this.po_value == "unknown") {
                    check_flag = false;
                    check_total = false;

                }

                // alert($("#po_value").val())
                if (check_flag) {
                    if (this.basic_amount > parseInt(this.po_value)) {
                        this.basic_amount=this.old_basic_amount;
                    swal('error', "Basic Amount Can't be Greater than PO Amount", 'error')
                    return 1;

                }
                } 
                if (check_total) {
                    if (this.total_amount > parseInt(this.po_value)) {
                        this.total_amount=this.old_total_amount;
                    swal('error', "Total Amount Can't be Greater than PO Amount", 'error')
                    return 1;

                }
                }

                axios.post('/edit_invoice_details', {
                        'unid': this.unique_id,
                        'po_id': this.po_id,
                        'po_value': this.po_value,
                        'received_date': this.date_of_receipt,
                        'basic_amount': this.basic_amount,
                        'total_amount': this.total_amount,
                        'invoice_no': this.invoice_number,
                        'invoice_date': this.invoice_date,
                        'role':'sourcing_admin',
                        'admin_remarks':this.sourcing_admin_remarks,
                    })
                    .then(response => {
                        // console.log(response.data);
                        if (response.data) {
                            // alert(this.unique_id)
                            // dt.row(0).cells().invalidate().render()
                            swal('success', "Record has been updated Successfully!!!", 'success')
                            // document.getElementById("search_item").value = "";
                            this.unique_id = "";
                            window.location.href = '/invoices';
                            // $('#html5-extension').DataTable().response.data.reload();
                        } 

                    }).catch(error => {

                     
                    })


            },
            get_data_by_id: function() {
                axios.post('/get_invoice_data', {
                        'unique_id': this.unique_id,
                    })
                    .then(response => {
                        // console.log(response.data)
                  
                        if(response.data){
                            this.actual_po_info = response.data[2].po_number+' : '+response.data[2].vendor_name+' : '+response.data[2].unit;
                            this.basic_amount=response.data[0].basic_amount;
                            this.total_amount=response.data[0].total_amount;
                            this.old_total_amount = this.total_amount;
                            this.old_basic_amount=this.basic_amount;
                            this.po_value=response.data[0].po_value;
                            this.date_of_receipt=response.data[0].date_of_receipt;
                            this.invoice_number=response.data[0].invoice_no;
                            this.invoice_date=response.data[0].invoice_date;
                            this.po_id=response.data[0].po_id;
                        }
                

                    }).catch(error => {
                      


                    })
            },
            upload_file(e) {
                this.file = e.target.files;
            },
            cancel_invoice: function() {
                this.unique_id = $("#unid").val();
                if (this.sourcing_remarks != "") {
                    axios.post('/cancel_invoice_with_po', {
                            'unid': this.unique_id,
                            'cancel_remarks': this.sourcing_remarks
                        })
                        .then(response => {
                            if (response.data) {
                                swal('success', "UNID :" + this.unique_id + " has been Cancelled", 'success')
                                window.location.href = '/invoices';
                            } else {
                                swal('error', "System Error", 'error')
                                this.cancel_ter_modal = false;
                                this.unid = "";
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.cancel_ter_modal = false;
                            this.ter_id = "";
                        })
                } else {
                    swal('error', "Remarks needs to be added", 'error')
                }
            },
            submit_sourcing_remarks: function() {

                this.unique_id = $("#unid").val();
                // if(this.file.length == 0)
                // {
                //     swal('error', "Sourcing File Needs to be added", 'error')
                //     return 1;
                // }
                if (this.sourcing_remarks != "") {

                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data',
                        }
                    }
                    let formData = new FormData();

               
                    for (var i = 0; i < this.file.length; i++) {
                    let file_names = this.file[i];
                    formData.append('scanning_file[' + i + ']',file_names);
                }
                 
                // alert(this.file.length);
                // return 1;

                    // formData.append('scanning_file', this.file);
                    formData.append('unid', this.unique_id);
                    formData.append('remarks', this.sourcing_remarks);


                    axios.post('/submit_sourcing_remarks', formData, config)
                        .then(response => {
                            if (response.data == 100) {
                                swal('error', "File not Found", 'error')
                                return 1;

                            }
                            if (response.data) {
                                swal('success', "Remarks for UNID :" + this.unique_id + " has been successfully submitted", 'success')
                                window.location.href = '/invoices';

                            } else {
                                swal('error', "System Error", 'error')
                                this.ter_modal = false;
                                this.unid = "";
                            }

                        }).catch(error => {

                            swal('error', error, 'error')
                            this.ter_modal = false;
                            this.unid = "";
                        })
                } else {
                    swal('error', "Remarks needs to be added", 'error')
                }
            },


        }
    })
</script>


@endsection