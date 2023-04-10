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
                                    <input type="text" class="form-control form-control-sm" name="po_number" id="po_number" value="<?php echo $po_data->po_number ?>" placeholder="" readonly>
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
                                    <input type="number" class="form-control form-control-sm" name="basic_amount" id="basic_amount" value="<?php echo $invoices_data->basic_amount ?>" placeholder="" readonly>
                                </div>
                                <div class="form-group mb-4 col-md-3">
                                    <label for="exampleFormControlInput2">Total Amount</label>
                                    <input type="number" class="form-control form-control-sm" name="total_amount" id="total_amount" value="<?php echo $invoices_data->total_amount ?>" placeholder="" readonly>
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

                            @if(empty($invoices_data->sourcing_remarks))
                            <div class="form-row mb-4">
                                <h6><b>Sourcing Remarks*</b></h6>

                                <div class="form-group mb-4 col-md-6" style="margin-top: 10px">
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" v-model="sourcing_remarks" placeholder="">
                                </div>

                            </div>
                            @else
                            <div class="form-row mb-4">
                                <h6><b>Sourcing Remarks*</b></h6>

                                <div class="form-group mb-4 col-md-6" style="margin-top: 10px">
                                    <input type="text" class="form-control form-control-sm" name="remarks" id="remarks" value="<?php echo $invoices_data->sourcing_remarks ?>" readonly>
                                </div>

                            </div>
                            @endif

                
                            @if(empty($invoices_data->sourcing_remarks))
                            <div class="col-12 d-flex align-items-center justify-content-end" style="gap:1rem;">
                                <a class="btn btn-outline-primary" href="{{url('/invoices') }}"> Back</a>
                                <button class="mt-4 mb-4 btn btn-primary" @click="submit_sourcing_remarks()">Submit</button>
                            </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    new Vue({
        el: '#divbox',
        // components: {
        //   ValidationProvider
        // },
        data: {

            unique_id: "",
            loader: false,
            sourcing_remarks: "",


        },
        created: function() {
            //   alert('hello');
            // var table=$('#html5-extension');
            // table.dataTable({dom : 'lrt'});
            // $('table').dataTable({bFilter: false, bInfo: false});
        },
        methods: {
            submit_sourcing_remarks: function() {
                this.unique_id = $("#unid").val();
                if (this.sourcing_remarks != "") {
                    axios.post('/submit_sourcing_remarks', {
                            'unid': this.unique_id,
                            'remarks': this.sourcing_remarks
                        })
                        .then(response => {
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