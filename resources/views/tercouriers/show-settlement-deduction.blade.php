@extends('layouts.main')
@section('title', 'Settlement Deduction Courier List')
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
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        width: 80px;
    }

    .statusButton svg {
        height: 14px;
        width: 14px;
    }

    .senderBlock {
        max-width: 300px;
        min-height: 30px;
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
</style>


<!-- END PAGE LEVEL CUSTOM STYLES -->
<div class="layout-px-spacing" id="divbox">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Settlement Deduction List</a></li>
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
                            <th>TER ID</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th>Sender</th>
                            <th>TER</th>
                            <th>AX Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tb">
                        @if(count($tercouriers) < 1) <tr>
                            <td colspan="9">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: min(45vh, 400px)">
                                    No data to display
                                </div>
                            </td>
                            </tr>
                            @else
                            @foreach ($tercouriers as $key => $tercourier)
                            <tr>
                                <td width="100px">
                                    {{$tercourier->id}}
                                </td>
                                <td width="100px">
                                    <div class="d-flex align-items-center" style="gap: 4px;">
                                        {{ $tercourier->parent_ter_id }}
                                        <div class="uid">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                            </svg>
                                            <div class="terDetails">
                                                <p>Given to <strong>{{ $tercourier->given_to ?? '-' }}</strong> on
                                                    <strong>{{ Helper::ShowFormatDate($tercourier->delivery_date) }}</strong>
                                                </p>
                                                <div class="courier d-flex align-items-center" style="gap: 1rem">
                                                    <p><strong>Courier
                                                            Name:</strong> {{ ucwords(@$tercourier->CourierCompany->courier_name) ?? '-' }}
                                                    </p> |
                                                    <p><strong>Docket
                                                            No.:</strong> {{ $tercourier->docket_no ?? '-' }}
                                                    </p>
                                                    |
                                                    <p><strong>Docket
                                                            Date:</strong> {{ Helper::ShowFormatDate($tercourier->docket_date) }}
                                                    </p>
                                                </div>
                                                <p>
                                                    <strong>Remarks:</strong> {{ ucfirst($tercourier->remarks) ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <?php
                                if ($tercourier->status == 7) {

                                    $status = 'Pay';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 3) {

                                    $status = 'Sent to Finfect';
                                    $class = 'btn-success';
                                } elseif ($tercourier->status == 5) {

                                    $status = 'Paid';
                                    $class = 'btn-success';
                                } else {
                                    $status = 'Repay';
                                    $class = 'btn-danger';
                                }
                                ?>

                                <td>
                                    @if ($tercourier->status == 3 || $role == "tr admin")
                                    <button type="button" class="btn statusButton btn-rounded {{ $class }}" disabled>{{ $status }}</button>
                                    @elseif($tercourier->status == 0)
                                    @if($role != "tr admin")
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton finfectResponseStatus" style="cursor: pointer" v-on:click="pay_now_ter(<?php echo $tercourier->parent_ter_id; ?>)" value="<?php echo $tercourier->id; ?>">
                                            {{ $status }}
                                        </button>
                                        <div class="finfectResponseDetail">
                                            <p>
                                                <strong>Response form Finfect:</strong> {{ ucfirst($tercourier->finfect_response) ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    @else
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton finfectResponseStatus" style="cursor: pointer">
                                            {{ $status }}
                                        </button>
                                        <div class="finfectResponseDetail">
                                            <p>
                                                <strong>Response form Finfect:</strong> {{ ucfirst($tercourier->finfect_response) ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <button type="button" class="btn {{ $class }}" v-on:click="pay_now_ter(<?php echo $tercourier->parent_ter_id; ?>)" value="<?php echo $tercourier->id; ?>">{{ $status }}</button>
                                    @endif
                                    <!-- @if($tercourier->status == 1 || $tercourier->status == 2)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#exampleModal">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @elseif($tercourier->status == 5)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#partialpaidModal" v-on:click="open_partial_paid_modal(<?php echo $tercourier->id ?>)">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @elseif($tercourier->status == 0 )
                                    <div style="position: relative;">
                                        <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton finfectResponseStatus" style="cursor: pointer">
                                            {{ $status }}
                                        </button>
                                        <div class="finfectResponseDetail">
                                            <p>
                                                <strong>Response form Finfect:</strong> {{ ucfirst($tercourier->finfect_response) ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    @else
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        {{ $status }}
                                    </button>
                                    @endif -->
                                </td>
                                <td>
                                    <ul class="dates d-flex flex-column justify-content-center">
                                        @if($tercourier->book_date)
                                        <li>
                                            Booked
                                            on: {{ Helper::ShowFormatDate($tercourier->book_date) }}</li>@endif
                                        @if($tercourier->date_of_receipt)
                                        <li>
                                            Courier: {{ Helper::ShowFormatDate($tercourier->date_of_receipt) }}</li>@endif
                                        @if($tercourier->handover_date)
                                        <li>
                                            Handover: {{ Helper::ShowFormatDate($tercourier->handover_date) }}</li>@endif
                                    </ul>
                                </td>
                                <td>
                                    <div class="senderBlock">
                                        <div class="senderId">
                                            <span>Emp ID: {{ $tercourier->employee_id ?? '-' }}</span>
                                            <span class="senderName">
                                                {{ ucwords(@$tercourier->employee_name) ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="senderLocation">
                                            <span>AX ID - {{ $tercourier->ax_id ?? '-' }}</span>
                                            <span>&nbsp;</span>
                                        </div>
                                    </div>
                                </td>
                                <!--ter-->
                                <td>
                                    <div class="terBlock">
                                        <div class="terDates flex-grow-1">
                                            <span class="terDate"><strong>{{ Helper::ShowFormatDate($tercourier->terfrom_date) }} - {{ Helper::ShowFormatDate($tercourier->terto_date) }}</strong></span>
                                            <div class="dates d-flex flex-column justify-content-center">
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Received:</div>
                                                    ₹{{ $tercourier->actual_amount ?? '-' }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Paid:</div>
                                                    ₹{{ $tercourier->prev_payable_sum ?? '-' }}
                                                </div>
                                                <div class="amount d-flex align-items-center justify-content-between ">
                                                    <div class="heading">Deduction:</div>
                                                    ₹{{ $tercourier->left_amount ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!--ax-->
                                <td>
                                    <div class="axDetails flex-grow-1">
                                        <div class="heading d-flex justify-content-between align-items-center" style="font-size: 12px; font-weight: 500;">Voucher: <span>Amount</span>
                                        </div>
                                        <div class="dates d-flex flex-column justify-content-center" style="width: 100%;">
                                            <div class="axVouchers flex-grow-1">
                                                <div class="heading" style="min-height: 30px;">
                                                <span class="d-flex flex-column">{{$tercourier->voucher_code ?? '-'}}</span>
                                                <span class="d-flex flex-column align-items-end">{{$tercourier->payable_amount ?? '-'}}</span>


                                                    <!-- <?php
                                                    $voucherCode = json_decode($tercourier->voucher_code);
                                                    $payableAmount = json_decode($tercourier->payable_amount);
                                                    ?>

                                                    <span class="d-flex flex-column">
                                                        @if(is_countable($voucherCode) && count($voucherCode) > 0)
                                                        @foreach($voucherCode as $voucher)
                                                        <span>{{$voucher}}</span>
                                                        @endforeach
                                                        @else
                                                        <span>-</span>
                                                        @endif
                                                    </span>
                                                    <span class="d-flex flex-column align-items-end">
                                                        @if(is_countable($payableAmount) && count($payableAmount) > 0)
                                                        @foreach($payableAmount as $amt)
                                                        <span>₹{{$amt}}</span>
                                                        @endforeach
                                                        @else
                                                        <span>-</span>
                                                        @endif
                                                    </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="action d-flex justify-content-center align-items-center">
                                        @if($tercourier->file_name != "")
                                        <a href="" data-toggle="modal" data-target="#viewFileModal" v-on:click="open_file_view_modal({{$tercourier->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        @else
                                        <a>-NA-</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                    </tbody>
                </table>
            </div>
            <div class="modal fade show" id="viewFileModal" v-if="file_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Uploaded File for @{{id}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="file_view_modal=false;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 bg-black">
                                <img id="view-src" :src="view_file_name" alt="sample image" style="width: 100%; max-height: 300px; border-radius: 12px;" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-outline-primary" :href="view_file_name" target="_blank" style="border-radius: 8px; display: flex;align-items: center;gap: 6px;">
                                Open in New Tab
                                <svg xmlns="http://www.w3.org/2000/svg" width="4" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link" style="height: 14px; width: 14px">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                            <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal" >Get Passbook</button> -->
                            <!-- <button type="button" class="btn btn-secondary"  data-dismiss="modal"  @click="emp_modal=false;emp_advance_amount=''">Close</button> -->
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
            unique_amount_id: "",
            unique_coupon_id: "",
            file_view_modal: false,
            id: "",
            view_file_name: "",
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            open_file_view_modal: function(ter_id) {
                // var file;
                // file=document.getElementById('table_file_name').value;
                this.id = ter_id;
                this.file_view_modal = true;
                axios.post('/get_file_name', {
                        'id': this.id,
                    })
                    .then(response => {
                        this.view_file_name = 'rejected_ter_uploads/' + response.data;
                        this.file_view_modal = true;
                    }).catch(error => {

                        swal('error', error, 'error')
                        this.file_view_modal = false;
                        this.ter_id = "";
                    })
            },
            select_all_trx: function() {
                var x = this.$el.querySelector("#select_all");
                var y = this.$el.querySelectorAll(".selected_box");
                if (x.checked == true) {
                    for (var i = 0; i < y.length; i++) {
                        y[i].checked = true;
                    }
                } else {
                    for (i = 0; i < y.length; i++) {
                        y[i].checked = false;
                    }
                }
            },

            group_pay_now: function() {
                var x = this.$el.querySelector("#tb");
                var box = x.querySelectorAll(".selected_box");
                var id = "";

                for (var i = 0; i < box.length; i++) {
                    // console.log(y[i].value);
                    if (box[i].checked) {
                        if (id == "") {
                            id += box[i].value;
                        } else {
                            id += "|" + box[i].value;
                        }
                    }
                }


                const id_array = id.split("|");
                if (id_array != "") {
                    axios.post('/group_pay_now', {
                            'selected_id': id
                        })
                        .then(response => {
                            console.log(response.data);
                            if (response.data >= 1) {
                                // alert('hello')
                                location.reload();
                            } else {
                                swal('error', "Either Record is already updated,not selected or greater payable amount", 'error')
                            }

                        }).catch(error => {

                            console.log(response)
                            this.apply_offer_btn = 'Apply';

                        })
                } else {
                    swal('error', "Either Record is not selected or field is empty", 'error')
                }

            },


            pay_now_ter: function($id) {
                var unique_id = $id;

                axios.post('/pay_later_ter_now', {
                        'selected_id': unique_id
                    })
                    .then(response => {
                        console.log(response.data);
                        if (response.data == 1) {

                            location.reload();
                        } else {
                            swal('error', "System Error", 'error')
                        }

                    }).catch(error => {

                        console.log(response)
                        this.apply_offer_btn = 'Apply';

                    })

            }
        }


    })
</script>

@endsection