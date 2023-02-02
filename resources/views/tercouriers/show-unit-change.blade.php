@extends('layouts.main')
@section('title', 'Unit Change Courier List')
@section('content')
<!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js" integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js" integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
<style>
    .btn {
        padding: 10px 10px;
        font-size: 10px;
    }

    .table>tbody>tr>th,
    .table>tbody>tr>td {
        padding: 10px;
    }

    .uid {
        display: flex;
        position: relative;
        cursor: pointer;
        width: max-content;
    }

    .uid svg {
        height: 14px;
        width: 14px;
    }

    .terDetails {
        z-index: 9999999;
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #ffffff;
        opacity: 0;
        display: none;
        box-shadow: 0 0 17px #83838360;
        border-radius: 12px;
        padding: 10px 16px;
        backdrop-filter: blur(10px);
    }

    .finfectResponseDetail {
        z-index: 9999999;
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background: #ffffff;
        opacity: 0;
        display: none;
        box-shadow: 0 0 17px #83838360;
        border-radius: 12px;
        padding: 10px 16px;
        backdrop-filter: blur(10px);
    }

    .finfectResponseStatus:hover+.finfectResponseDetail {
        opacity: 1;
        display: block;
    }

    .terDetails p {
        margin-bottom: 0;
    }

    .terDetails:before {
        content: '';
        display: block;
        height: 12px;
        width: 12px;
        background: #ffffff;
        position: absolute;
        left: -6px;
        top: 50%;
        transform: translateY(-50%) rotate(45deg);
    }

    .uid:hover>.terDetails {
        opacity: 1;
        display: block;

    }

    .statusButton {
        padding: 3px 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        min-width: 80px;
    }

    .statusButton svg {
        height: 14px;
        width: 14px;
    }

    .senderBlock {
        max-width: 300px;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 4px 8px;
        border-radius: 4px;
        background: #83838320;
    }

    .senderBlock .senderName {
        width: 110px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .senderBlock .senderId,
    .senderBlock .senderLocation {
        display: flex;
        flex-flow: column;
        justify-content: center;
        width: 110px;
    }

    .senderBlock .senderId span:nth-of-type(1),
    .senderBlock .senderLocation span:nth-of-type(1) {
        font-size: 12px;
    }

    .terBlock {
        display: flex;
        align-items: center;
        gap: 1rem;
        border-radius: 4px;
        background: #83838320;
        position: relative;
        width: 170px;
        padding: 2px 8px;
    }

    .axDetails {
        border-radius: 4px;
        background: #83838320;
        position: relative;
        width: 170px;
        padding: 2px 8px;
    }

    .terBlock {
        padding: 13px 8px 2px;
    }

    .terBlock .terDates,
    .terBlock .terAmount {
        display: flex;
        flex-flow: column;
        justify-content: center;
    }

    .dates {
        font-size: 12px;
        line-height: 15px;
        padding-left: 4px;
        margin-bottom: 0;
    }

    .dates p {
        margin: 0;
    }

    .dates .amount {
        flex: 1;
    }

    .amount .heading {
        width: 60px !important;
        margin-right: 4px;
    }

    .terDate {
        position: absolute;
        top: -5px;
        font-size: 11px;
        left: 50%;
        transform: translateX(-50%);
        background: #4361ee;
        color: #fff;
        padding: 2px 6px;
        line-height: 12px;
        border-radius: 4px;
    }

    .axVouchers {
        max-height: 30px;
        overflow-y: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .axVouchers .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .axVouchers::-webkit-scrollbar {
        display: none;
    }

    .action svg {
        height: 16px;
        width: 16px;
        cursor: pointer;
        transition: all 200ms ease-in-out;
    }

    .action svg:hover {
        color: #4361ee;
    }

    .form-control-sm-30px {
        height: 30px;
    }

    .form-control-sm-30 {
        height: calc(2.8em + 2px);
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

    .floatingButton {
        border-radius: 12px;
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        font-size: 1rem;
        display: flex;
        font-weight: 500;
        justify-content: center;
        align-items: center;
        height: 50px;
        width: 50px;
        overflow: hidden;
        transition: all 300ms ease-in-out;
    }

    .floatingButton span.text {
        display: none;
        white-space: nowrap;
        opacity: 0;
        transform: translateX(10px);
        transition: all 200ms ease-in-out;
    }

    .floatingButton:hover {
        width: 140px;
    }

    .floatingButton:hover span.text {
        margin-left: 8px;
        opacity: 1;
        display: inline-flex;
        transform: translateX(0px);
        transition: opacity 300ms ease-in-out, transform 200ms ease-in-out;
    }

    .closeButton {
        cursor: pointer;
        position: absolute;
        right: 1rem;
        top: 1rem;
        color: #000;
        height: 20px;
        width: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50vh;
        background: #fff;
    }

    .actionButtons {
        height: 30px;
        width: 80px;
        border-radius: 8px;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .actionButtons svg {
        height: 14px;
        width: 14px;
    }

    .searchField svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        height: 14px;
        width: 14px;
    }

    .searchField input {
        padding-left: 30px;
    }

    .unitBox {
        background: #f0f0f0;
        border-radius: 12px;
        list-style: none;
        padding: 8px 16px;
    }
    .unitBox li span{
        font-weight: 500;
        color: #000;
    }
</style>



<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Unit Change List</a></li>
            </ol>
        </nav>
    </div>

    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

            <!---new view--->
            <div class="widget-content widget-content-area br-6" style="overflow-x: auto">


                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th>OLD UNit Details</th>
                            <th>New UNit Details</th>
                            <th>TER</th>
                        </tr>
                    </thead>
                    <tbody id="tb">
                        @if(count($tercouriers) < 1) <tr>
                            <td colspan="8">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: min(45vh, 400px)">
                                    No data to display
                                </div>
                            </td>
                            </tr>
                            @else
                            @foreach ($tercouriers as $key => $tercourier)
                            <tr>
                                <td width="100px">
                                    <div class="d-flex align-items-center" style="gap: 4px;">
                                        {{ $tercourier->id }}
                                    </div>
                                </td>

                                <?php
                                if ($tercourier->status == 12) {
                                    if ($role == "Hr Admin") {
                                        $status = 'Unit Change';
                                        $class = 'btn-warning';
                                    }
                                }
                                ?>

                                <td>
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: pointer" data-toggle="modal" data-target="#hrApprovalModal" @click="open_hr_approval_modal(<?php echo $tercourier->id; ?>)" value="<?php echo $tercourier->id; ?>">
                                            {{ $status }}
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <ul class="dates d-flex flex-column justify-content-center">
                                        @if($tercourier->received_date)
                                        <li>
                                            Receipt: {{ Helper::ShowFormatDate($tercourier->received_date) }}</li>@endif
                                        @if($tercourier->date_of_receipt)
                                        <li>
                                            Courier: {{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</li>@endif
                                        @if($tercourier->handover_date)
                                        <li>
                                            Handover: {{ Helper::ShowFormatDate($tercourier->handover_date) }}</li>@endif
                                    </ul>
                                </td>
                                <td>
                                    <ul class="dates d-flex flex-column justify-content-center">
                                        <li>
                                            AX-ID: {{ $tercourier->ax_id }}</li>

                                        <li>
                                            IAG CODE: {{ $tercourier->iag_code  }}</li>

                                        <li>
                                            PFU: {{ $tercourier->pfu }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="dates d-flex flex-column justify-content-center">
                                        <li>
                                            AX-ID: {{ $tercourier->SenderDetail->ax_id }}</li>

                                        <li>
                                            IAG CODE: {{ $tercourier->SenderDetail->iag_code  }}</li>

                                        <li>
                                            PFU: {{ $tercourier->SenderDetail->pfu }}</li>
                                    </ul>
                                </td>
                                <!--ter-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }} - {{ Helper::ShowFormatDate($tercourier->terto_date) }}</strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Claimed:</div>
                                                    ₹{{ $tercourier->amount ?? '-' }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Paid:</div>
                                                    <?php
                                                    $payableAmount = json_decode($tercourier->payable_amount);
                                                    if (is_countable($payableAmount) && count($payableAmount) > 0) {
                                                        $totalPayableAmount = array_sum($payableAmount);
                                                    }
                                                    ?>
                                                    @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                    ₹{{ $totalPayableAmount }}
                                                    @else
                                                    ₹ 0
                                                    @endif
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Deduction:</div>
                                                    @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                    ₹{{ ((int)$totalPayableAmount - (int)$tercourier->amount) }}
                                                    @else
                                                    ₹ 0
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                    </tbody>
                </table>

            </div>


            <!-- HR approval Modal -->
            <div class="modal fade show" id="hrApprovalModal" v-if="hr_approval_modal" tabindex="-1" role="dialog" aria-labelledby="hrApprovalModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: none">
                            <h5 class="modal-title" id="hrApprovalModalLabel"> TER ID: @{{ter_id}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="hr_approval_modal=false;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div v-if="hr_approval_modal_details_loading" class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px">
                                Loading...
                            </div>
                        </div>
                        <div v-else class="modal-body">
                            <div class="mb-4" style="border-radius: 12px; min-height: 150px; width: 100%;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap" style="column-gap: 1rem; padding: 0 1rem">
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">Old Units</label>
                                        <ul class="unitBox">
                                            <li>AX ID: <span>@{{old_units.ax_id}}</span></li>
                                            <li>IAG: <span>@{{old_units.iag_code}}</span></li>
                                            <li>PFU: <span>@{{old_units.pfu}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">New Unit</label>
                                        <ul class="unitBox">
                                            <li>AX ID: <span>@{{new_units.ax_id}}</span></li>
                                            <li>IAG: <span>@{{new_units.iag_code}}</span></li>
                                            <li>PFU: <span>@{{new_units.pfu}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between flex-wrap" style="column-gap: 1rem; padding: 0 1rem">
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">TER Period From</label>
                                        <input type="date" class="form-control form-control-sm" id="recipient-name" v-model="from_date">
                                    </div>
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">TER Period To</label>
                                        <input type="date" class="form-control form-control-sm" id="recipient-name" v-model="to_date">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap" style="column-gap: 1rem; padding: 0 1rem">
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">Effective Date of Shifting*</label>
                                        <input type="date" class="form-control form-control-sm" id="recipient-name" v-model="effective_date">
                                    </div>
                                    <div class="form-group" style="flex: 1;">
                                        <label for="recipient-name" class="col-form-label">Remarks</label>
                                        <input type="text" class="form-control form-control-sm" id="recipient-name" v-model="remarks">
                                    </div>
                                </div>



                            </div>
                        </div>
                        @if($role == "Hr Admin")
                        <div class="modal-footer" style="border-top: none;">

                        <label for="recipient-name" class="col-form-label justify-center" style="flex: 1"><strong>Ter Paid From*</strong></label>

                            <button type="button" class="btn btn-secondary" style="min-width: 100px; border-color: #e2a03f; background-color: #e2a03f;" data-dismiss="modal" aria-label="Close" @click="change_unit_status('old')">
                                OLD Unit
                            </button>

                            <button type="button" style="min-width: 100px" class="btn btn-primary" data-dismiss="modal" v-on:click="change_unit_status('new')">New Unit</button>
                        </div>
                        @endif

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
            ter_id: "",
            hr_approval_modal_details_loading: false,
            hr_approval_modal: false,
            from_date: "",
            to_date: "",
            effective_date: "",
            remarks: "",
            old_units:{},
            new_units:{},
            selected_unit:"",

        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            change_unit_status: function(unit) {
                this.selected_unit=unit;
                if (this.effective_date != "") {
                    axios.post('/submit_change_unit', {
                            'remarks': this.remarks,
                            'id': this.ter_id,
                            'selected_unit': this.selected_unit,
                            'effective_date':this.effective_date,
                            'from_date':this.from_date,
                            'to_date':this.to_date
                        })
                        .then(response => {
                            if (response.data == '1') {
                                swal('success', 'Updated Successfully!', 'success')
                                location.reload();
                                // console.log(response.data[0].status)
                            }
                        }).catch(error => {

                            console.log(response)
                            this.apply_offer_btn = 'Apply';

                        })
                } else {
                    swal('error', 'Effective Date of Shifting is mandatory', 'error')
                }
            },
            open_hr_approval_modal: function(ter_id) {
                this.ter_id = ter_id;
                this.from_date = "";
                this.to_date = "";
                this.old_units={};
                this.new_units={};
                // alert(this.remarks)
                // alert(this.ter_id)
                // return 1;
                axios.post('/get_unit_details', {
                        'id': this.ter_id
                    })
                    .then(response => {
                        if (response.data) {

                            this.hr_approval_modal_details_loading = false;
                            this.from_date = response.data[0].terfrom_date;
                            this.to_date = response.data[0].terto_date;
                            this.old_units=response.data[0];
                            this.new_units=response.data[0].sender_detail;

                            // console.log(response.data[0].status)
                        }
                    }).catch(error => {

                        // console.log(response)
                        // this.apply_offer_btn = 'Apply';

                    })
                this.hr_approval_modal = true;
            },

        }


    })
</script>

@endsection